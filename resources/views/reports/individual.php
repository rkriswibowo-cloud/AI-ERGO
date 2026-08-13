<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Individual Ergonomi - <?= sanitize($assessment['employee_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: system-ui, sans-serif; background: #f8fafc; color: #1e293b; }
        .report-card { background: #fff; border-radius: 1rem; padding: 2.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .report-card { box-shadow: none !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="py-4">

<div class="container no-print mb-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2">
        <a href="<?= base_url("assessments/show/{$assessment['id']}") ?>" class="btn btn-light rounded-pill btn-mobile-full"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Aplikasi</a>
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm btn-mobile-full"><i class="fa-solid fa-print me-1"></i> Cetak Dokumen PDF</button>
    </div>
</div>

<div class="container col-lg-9">
    <div class="report-card border">
        <!-- Header Dokumen -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h3 class="fw-bold text-primary mb-0"><i class="fa-solid fa-person-walking-luggage me-2"></i>AI-ERGO REPORT</h3>
                <p class="text-muted small mb-0">Laporan Penilaian Risiko Ergonomi & Rekomendasi AI</p>
            </div>
            <div class="text-end">
                <h6 class="fw-bold text-dark mb-0"><?= sanitize($assessment['company_name']) ?></h6>
                <p class="text-muted small mb-0">Tanggal Assessment: <?= date('d F Y', strtotime($assessment['assessment_date'])) ?></p>
            </div>
        </div>

        <!-- Biodata Worker -->
        <div class="mb-4">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-id-card me-2"></i>PROFIL PEKERJA & JABATAN</h6>
            <div class="row g-2 small">
                <div class="col-md-6">
                    <div><strong>NIK/NIP:</strong> <?= sanitize($assessment['employee_number']) ?></div>
                    <div><strong>Nama Pekerja:</strong> <?= sanitize($assessment['employee_name']) ?></div>
                    <div><strong>Usia / Gender:</strong> <?= $assessment['age'] ?> Th / <?= $assessment['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
                    <div><strong>Tinggi / Berat:</strong> <?= $assessment['height'] ?> cm / <?= $assessment['weight'] ?> kg</div>
                </div>
                <div class="col-md-6">
                    <div><strong>Departemen:</strong> <?= sanitize($assessment['department_name']) ?></div>
                    <div><strong>Jabatan:</strong> <?= sanitize($assessment['position_name']) ?></div>
                    <div><strong>Jenis Pekerjaan:</strong> <?= sanitize($assessment['job_type'] ?? '-') ?></div>
                    <div><strong>Durasi Duduk / Komputer:</strong> <?= $assessment['sitting_hours'] ?? 0 ?> jam / <?= $assessment['computer_hours'] ?? 0 ?> jam per hari</div>
                </div>
            </div>
        </div>

        <!-- Assessment Score -->
        <div class="mb-4">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-square-poll-vertical me-2"></i>HASIL ASSESSMENT NORDIC BODY MAP</h6>
            <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="text-muted small fw-semibold">SKOR TOTAL NBM</span>
                    <h3 class="fw-bold text-primary mb-0"><?= $assessment['total_score'] ?> / 84</h3>
                </div>
                <div class="text-end">
                    <span class="text-muted small fw-semibold">TINGKAT RISKO ERGONOMI</span>
                    <div><?= risk_badge($assessment['risk_level']) ?></div>
                </div>
            </div>
            <div class="mb-3">
                <strong>Area Tubuh Keluhan Utama:</strong>
                <div class="p-2 bg-warning-subtle text-dark border rounded mt-1 small">
                    <?= sanitize($assessment['dominant_body_area'] ?? 'Tidak ada keluhan signifikan') ?>
                </div>
            </div>
        </div>

        <!-- AI Recommendation Content -->
        <div class="mb-4">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-robot me-2"></i>REKOMENDASI PERBAIKAN ERGONOMI KERTAS KERJA (AI)</h6>
            <?php if (!empty($aiRecommendation)): ?>
                <div class="p-3 bg-light rounded border small" style="white-space: pre-wrap; font-family: inherit; line-height: 1.6;">
                    <?= sanitize($aiRecommendation['recommendation_text']) ?>
                </div>
            <?php else: ?>
                <p class="text-muted small fst-italic">Belum ada rekomendasi AI yang di-generate untuk assessment ini.</p>
            <?php endif; ?>
        </div>

        <!-- Signature Box -->
        <div class="row pt-4 mt-4 border-top text-center small">
            <div class="col-6">
                <p class="mb-5">Mengetahui,<br><strong>Tim K3 / Supervisor</strong></p>
                <p class="mb-0">__________________________</p>
            </div>
            <div class="col-6">
                <p class="mb-5">Divalidasi Oleh,<br><strong>Ergonomist / Specialist K3</strong></p>
                <p class="mb-0">__________________________</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
