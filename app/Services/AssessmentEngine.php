<?php

namespace App\Services;

class AssessmentEngine {

    public static function getBodyParts(): array {
        return [
            'neck_upper'       => 'Leher Atas (Upper Neck)',
            'neck_lower'       => 'Leher Bawah (Lower Neck)',
            'shoulder_left'    => 'Bahu Kiri (Left Shoulder)',
            'shoulder_right'   => 'Bahu Kanan (Right Shoulder)',
            'arm_upper_left'   => 'Lengan Atas Kiri (Left Upper Arm)',
            'back_upper'       => 'Punggung (Upper Back)',
            'arm_upper_right'  => 'Lengan Atas Kanan (Right Upper Arm)',
            'waist'            => 'Pinggang (Waist / Lower Back)',
            'hips'             => 'Pinggul (Hips)',
            'bottom'           => 'Pantat (Buttocks)',
            'elbow_left'       => 'Siku Kiri (Left Elbow)',
            'elbow_right'      => 'Siku Kanan (Right Elbow)',
            'forearm_left'     => 'Lengan Bawah Kiri (Left Forearm)',
            'forearm_right'    => 'Lengan Bawah Kanan (Right Forearm)',
            'wrist_left'       => 'Pergelangan Tangan Kiri (Left Wrist)',
            'wrist_right'      => 'Pergelangan Tangan Kanan (Right Wrist)',
            'hand_left'        => 'Tangan Kiri (Left Hand)',
            'hand_right'       => 'Tangan Kanan (Right Hand)',
            'thigh_left'       => 'Paha Kiri (Left Thigh)',
            'thigh_right'      => 'Paha Kanan (Right Thigh)',
            'knee_left'        => 'Lutut Kiri (Left Knee)',
            'knee_right'       => 'Lutut Kanan (Right Knee)',
            'calf_left'        => 'Betis Kiri (Left Calf)',
            'calf_right'       => 'Betis Kanan (Right Calf)',
            'ankle_left'       => 'Pergelangan Kaki Kiri (Left Ankle)',
            'ankle_right'      => 'Pergelangan Kaki Kanan (Right Ankle)',
            'foot_left'        => 'Kaki Kiri (Left Foot)',
            'foot_right'       => 'Kaki Kanan (Right Foot)',
        ];
    }

    public static function calculateScore(array $scores): int {
        $total = 0;
        foreach (self::getBodyParts() as $code => $name) {
            $val = isset($scores[$code]) ? (int)$scores[$code] : 0;
            if ($val < 0) $val = 0;
            if ($val > 3) $val = 3;
            $total += $val;
        }
        return $total;
    }

    public static function determineRiskLevel(int $totalScore): string {
        if ($totalScore <= 20) {
            return 'Rendah';
        } elseif ($totalScore <= 41) {
            return 'Sedang';
        } elseif ($totalScore <= 62) {
            return 'Tinggi';
        } else {
            return 'Sangat Tinggi';
        }
    }

    public static function getDominantBodyAreas(array $scores): string {
        $bodyParts = self::getBodyParts();
        $severe = [];
        foreach ($scores as $code => $score) {
            if ($score >= 2 && isset($bodyParts[$code])) {
                $cleanName = explode(' (', $bodyParts[$code])[0];
                $severe[] = $cleanName;
            }
        }
        return !empty($severe) ? implode(', ', $severe) : 'Tidak ada keluhan signifikan';
    }
}
