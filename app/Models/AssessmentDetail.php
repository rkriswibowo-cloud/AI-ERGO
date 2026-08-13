<?php

namespace App\Models;

use Core\Model;

class AssessmentDetail extends Model {
    protected string $table = 'assessment_details';

    public function getByAssessmentId(int $assessmentId): array {
        return $this->where('assessment_id', $assessmentId);
    }

    public function getTopBodyComplaints(int $companyId = null, int $limit = 5): array {
        $sql = "SELECT ad.body_part_name, SUM(ad.score) as total_score, COUNT(CASE WHEN ad.score >= 2 THEN 1 END) as severe_count
                FROM assessment_details ad
                JOIN assessments a ON ad.assessment_id = a.id
                JOIN employees e ON a.employee_id = e.id";
        $params = [];
        if ($companyId !== null) {
            $sql .= " WHERE e.company_id = :company_id";
            $params['company_id'] = $companyId;
        }
        $sql .= " GROUP BY ad.body_part_code, ad.body_part_name
                  ORDER BY total_score DESC LIMIT {$limit}";
        return $this->rawQuery($sql, $params);
    }
}
