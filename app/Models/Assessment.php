<?php

namespace App\Models;

use Core\Model;

class Assessment extends Model {
    protected string $table = 'assessments';

    public function getWithDetails(int $companyId = null, int $employeeId = null): array {
        $sql = "SELECT a.*, e.name as employee_name, e.employee_number, e.gender, e.age, e.height, e.weight,
                       c.name as company_name, d.name as department_name, p.name as position_name,
                       u.name as assessor_name,
                       air.id as ai_rec_id, air.ai_provider, air.ai_model, air.created_at as ai_generated_at
                FROM assessments a
                JOIN employees e ON a.employee_id = e.id
                LEFT JOIN companies c ON e.company_id = c.id
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN positions p ON e.position_id = p.id
                LEFT JOIN users u ON a.assessor_id = u.id
                LEFT JOIN ai_recommendations air ON a.id = air.assessment_id";

        $where = [];
        $params = [];

        if ($companyId !== null) {
            $where[] = "e.company_id = :company_id";
            $params['company_id'] = $companyId;
        }

        if ($employeeId !== null) {
            $where[] = "a.employee_id = :employee_id";
            $params['employee_id'] = $employeeId;
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY a.id DESC";
        return $this->rawQuery($sql, $params);
    }

    public function findWithDetails(int $id): ?array {
        $sql = "SELECT a.*, e.name as employee_name, e.employee_number, e.gender, e.age, e.height, e.weight, e.years_of_service,
                       c.name as company_name, d.name as department_name, p.name as position_name,
                       u.name as assessor_name,
                       jp.job_type, jp.sitting_hours, jp.standing_hours, jp.computer_hours, jp.shift_type
                FROM assessments a
                JOIN employees e ON a.employee_id = e.id
                LEFT JOIN companies c ON e.company_id = c.id
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN positions p ON e.position_id = p.id
                LEFT JOIN users u ON a.assessor_id = u.id
                LEFT JOIN job_profiles jp ON e.id = jp.employee_id
                WHERE a.id = :id LIMIT 1";
        $res = $this->rawQuery($sql, ['id' => $id]);
        return $res[0] ?? null;
    }

    public function getRiskStats(int $companyId = null): array {
        $sql = "SELECT risk_level, COUNT(*) as count 
                FROM assessments a
                JOIN employees e ON a.employee_id = e.id";
        $params = [];
        if ($companyId !== null) {
            $sql .= " WHERE e.company_id = :company_id";
            $params['company_id'] = $companyId;
        }
        $sql .= " GROUP BY risk_level";
        $rows = $this->rawQuery($sql, $params);

        $stats = ['Rendah' => 0, 'Sedang' => 0, 'Tinggi' => 0, 'Sangat Tinggi' => 0];
        foreach ($rows as $row) {
            if (isset($stats[$row['risk_level']])) {
                $stats[$row['risk_level']] = (int)$row['count'];
            }
        }
        return $stats;
    }
}
