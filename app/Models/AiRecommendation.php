<?php

namespace App\Models;

use Core\Model;

class AiRecommendation extends Model {
    protected string $table = 'ai_recommendations';

    public function getLatestByAssessment(int $assessmentId): ?array {
        $sql = "SELECT * FROM ai_recommendations WHERE assessment_id = :assessment_id ORDER BY id DESC LIMIT 1";
        $res = $this->rawQuery($sql, ['assessment_id' => $assessmentId]);
        return $res[0] ?? null;
    }
}
