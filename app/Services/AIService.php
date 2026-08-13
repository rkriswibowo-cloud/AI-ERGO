<?php

namespace App\Services;

use App\Models\Setting;

class AIService {

    public static function generateRecommendation(array $assessment, array $details): array {
        $settingModel = new Setting();
        $settings = $settingModel->getAllAsKeyValue();

        $provider = $settings['AI_PROVIDER'] ?? config('ai.default_provider', 'gemini');
        $geminiKey = $settings['GEMINI_API_KEY'] ?? config('ai.gemini.api_key', '');
        $groqKey = $settings['GROQ_API_KEY'] ?? config('ai.groq.api_key', '');
        $model = $settings['AI_MODEL'] ?? ($provider === 'gemini' ? 'gemini-1.5-flash' : 'llama-3.3-70b-versatile');

        // Build prompt
        $prompt = self::buildPrompt($assessment, $details);

        $recommendationText = '';
        $usedProvider = $provider;

        if ($provider === 'gemini' && !empty($geminiKey)) {
            $recommendationText = self::callGeminiAPI($geminiKey, $model, $prompt);
        } elseif ($provider === 'groq' && !empty($groqKey)) {
            $recommendationText = self::callGroqAPI($groqKey, $model, $prompt);
        }

        // Fallback generator if API response is empty or unconfigured
        if (empty($recommendationText)) {
            $usedProvider = $provider . ' (Local Fallback Engine)';
            $recommendationText = self::generateLocalFallback($assessment, $details);
        }

        return [
            'provider' => $usedProvider,
            'model' => $model,
            'prompt' => $prompt,
            'recommendation' => $recommendationText
        ];
    }

    private static function buildPrompt(array $assessment, array $details): string {
        $nbmSummary = [];
        foreach ($details as $d) {
            $scoreText = ['0' => 'Tidak Sakit', '1' => 'Agak Sakit', '2' => 'Sakit', '3' => 'Sangat Sakit'][$d['score']] ?? 'Tidak Sakit';
            if ($d['score'] > 0) {
                $nbmSummary[] = "- {$d['body_part_name']}: {$scoreText} (Skor {$d['score']})";
            }
        }
        $nbmText = !empty($nbmSummary) ? implode("\n", $nbmSummary) : "Tidak ada keluhan tubuh yang dilaporkan.";

        return "Anda adalah seorang pakar ergonomi profesional dan spesialis Keselamatan dan Kesehatan Kerja (K3).
Lakukan analisis mendalam dan berikan rekomendasi perbaikan ergonomi kerja berdasarkan data berikut:

DATA PEKERJA:
- Nama: {$assessment['employee_name']} ({$assessment['employee_number']})
- Usia: {$assessment['age']} tahun
- Jenis Kelamin: " . ($assessment['gender'] == 'L' ? 'Laki-laki' : 'Perempuan') . "
- Tinggi / Berat Badan: {$assessment['height']} cm / {$assessment['weight']} kg
- Masa Kerja: {$assessment['years_of_service']} tahun
- Departemen / Jabatan: {$assessment['department_name']} / {$assessment['position_name']}
- Perusahaan: {$assessment['company_name']}

PROFIL PEKERJAAN:
- Jenis Pekerjaan: " . ($assessment['job_type'] ?? 'Pekerja Kantor / Lapangan') . "
- Durasi Duduk Harian: " . ($assessment['sitting_hours'] ?? '0') . " jam
- Durasi Berdiri Harian: " . ($assessment['standing_hours'] ?? '0') . " jam
- Penggunaan Komputer: " . ($assessment['computer_hours'] ?? '0') . " jam
- Shift Kerja: " . ($assessment['shift_type'] ?? 'Non-Shift') . "

HASIL NORDIC BODY MAP (NBM):
- Total Skor NBM: {$assessment['total_score']} (Skala Max 84)
- Tingkat Risiko: {$assessment['risk_level']}
- Area Dominan Keluhan: {$assessment['dominant_body_area']}

RINCIAN KELUHAN BAGIAN TUBUH:
{$nbmText}

MINTA DIBERIKAN REKOMENDASI TERSTRUKTUR DALAM FORMAT MARKDOWN BERIKUT:
1. ### 1. Analisis Kondisi Ergonomi & Risiko Dominan
2. ### 2. Rekomendasi Perbaikan Postur (Posture Adjustments)
3. ### 3. Rekomendasi Aktivitas & Peregangan (Stretching & Microbreak)
4. ### 4. Rekomendasi Peralatan & Workstation Ergonomi (Ergonomic Equipment)
5. ### 5. Tindakan Preventif & Rencana Evaluasi Berkelanjutan";
    }

    private static function callGeminiAPI(string $apiKey, string $model, string $prompt): string {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;
        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err || !$response) return '';

        $json = json_decode($response, true);
        return $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    private static function callGroqAPI(string $apiKey, string $model, string $prompt): string {
        $url = "https://api.groq.com/openai/v1/chat/completions";
        $payload = [
            "model" => $model,
            "messages" => [
                ["role" => "system", "content" => "Anda adalah ahli ergonomi dan pakar K3 profesional."],
                ["role" => "user", "content" => $prompt]
            ],
            "temperature" => 0.7
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err || !$response) return '';

        $json = json_decode($response, true);
        return $json['choices'][0]['message']['content'] ?? '';
    }

    private static function generateLocalFallback(array $assessment, array $details): string {
        $name = $assessment['employee_name'] ?? 'Pekerja';
        $risk = $assessment['risk_level'] ?? 'Sedang';
        $score = $assessment['total_score'] ?? 0;
        $dominant = $assessment['dominant_body_area'] ?? 'Seluruh Tubuh';
        $sitting = $assessment['sitting_hours'] ?? 4;
        $job = $assessment['job_type'] ?? 'Pekerja';

        $recommendation = "### 1. Analisis Kondisi Ergonomi & Risiko Dominan\n";
        $recommendation .= "Pekerja **{$name}** ({$job}) memiliki hasil evaluasi Nordic Body Map dengan total skor **{$score}**, yang mengindikasikan tingkat risiko ergonomi **{$risk}**.\n";
        $recommendation .= "Area tubuh dengan tingkat keluhan paling signifikan berada pada **{$dominant}**.\n\n";

        $recommendation .= "### 2. Rekomendasi Perbaikan Postur (Posture Adjustments)\n";
        if ($sitting > 5) {
            $recommendation .= "- **Penataan Monitor**: Atur tinggi layar komputer agar bagian 1/3 atas layar sejajar dengan mata untuk mencegah penegangan otot leher.\n";
            $recommendation .= "- **Dukungan Tulang Belakang**: Pastikan bagian bawah punggung tersangga penuh oleh *lumbar support* dengan kemiringan sandaran 100°–110°.\n";
            $recommendation .= "- **Posisi Lengan & Siku**: Pertahankan siku pada sudut 90° saat mengetik dan sejajarkan ketinggian pergelangan tangan dengan meja.\n";
        } else {
            $recommendation .= "- **Posisi Berdiri**: Hindari bertumpu pada satu kaki dalam waktu lama. Distribusikan berat badan secara seimbang.\n";
            $recommendation .= "- **Pengangkatan Beban**: Gunakan teknik *squat* (bengkokkan lutut, punggung lurus) jika perlu mengangkat atau memindahkan barang.\n";
        }

        $recommendation .= "\n### 3. Rekomendasi Aktivitas & Peregangan (Stretching & Microbreak)\n";
        $recommendation .= "- **Aturan 20-20-20**: Setiap 20 menit bekerja di depan layar, alihkan pandangan ke objek jauh (6 meter) selama 20 detik.\n";
        $recommendation .= "- **Peregangan Leher & Bahu**: Lakukan pemutaran bahu (*shoulder rolls*) dan *neck stretches* sebanyak 3 kali sehari selama 2-3 menit.\n";
        $recommendation .= "- **Microbreak Harian**: Luangkan waktu 2-5 menit tiap 1-2 jam untuk berdiri dan berjalan ringan di ruang kerja.\n";

        $recommendation .= "\n### 4. Rekomendasi Peralatan & Workstation Ergonomi (Ergonomic Equipment)\n";
        $recommendation .= "- **Kursi Kerja Ergonomis**: Disarankan memakai kursi dengan pengatur ketinggian, *lumbar support*, dan *armrest* yang dapat disesuaikan.\n";
        $recommendation .= "- **Mouse & Keyboard Ergonomis**: Pertimbangkan penggunaan *vertical mouse* untuk mengurangi beban rotasi pada pergelangan tangan.\n";
        $recommendation .= "- **Footrest**: Sediakan sandaran kaki jika telapak kaki tidak menapak rata di lantai saat duduk.\n";

        $recommendation .= "\n### 5. Tindakan Preventif & Rencana Evaluasi Berkelanjutan\n";
        $recommendation .= "- **Evaluasi Re-Assessment**: Lakukan penilaian ulang Nordic Body Map dalam rentang waktu **30 hari** pasca perbaikan stasiun kerja.\n";
        $recommendation .= "- **Edukasi K3**: Ikuti sesi sosialisasi postur ergonomi dan peregangan mandiri yang diselenggarakan oleh Tim K3 Organisasi.";

        return $recommendation;
    }
}
