<?php

namespace App\Models;

use Core\Model;

class Employee extends Model {
    protected string $table = 'employees';

    public function getWithDetails(int $companyId = null): array {
        $sql = "SELECT e.*, c.name as company_name, d.name as department_name, p.name as position_name,
                       jp.job_type, jp.sitting_hours, jp.standing_hours, jp.computer_hours, jp.shift_type
                FROM employees e
                LEFT JOIN companies c ON e.company_id = c.id
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN positions p ON e.position_id = p.id
                LEFT JOIN job_profiles jp ON e.id = jp.employee_id";
        
        $params = [];
        if ($companyId !== null) {
            $sql .= " WHERE e.company_id = :company_id";
            $params['company_id'] = $companyId;
        }

        $sql .= " ORDER BY e.id DESC";
        return $this->rawQuery($sql, $params);
    }

    public function findWithDetails(int $id): ?array {
        $sql = "SELECT e.*, c.name as company_name, d.name as department_name, p.name as position_name,
                       jp.job_type, jp.sitting_hours, jp.standing_hours, jp.computer_hours, jp.shift_type, jp.work_duration
                FROM employees e
                LEFT JOIN companies c ON e.company_id = c.id
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN positions p ON e.position_id = p.id
                LEFT JOIN job_profiles jp ON e.id = jp.employee_id
                WHERE e.id = :id LIMIT 1";
        $res = $this->rawQuery($sql, ['id' => $id]);
        return $res[0] ?? null;
    }

    public function findByEmail(string $email): ?array {
        $sql = "SELECT e.*, c.name as company_name, d.name as department_name, p.name as position_name,
                       jp.job_type, jp.sitting_hours, jp.standing_hours, jp.computer_hours, jp.shift_type, jp.work_duration
                FROM employees e
                LEFT JOIN companies c ON e.company_id = c.id
                LEFT JOIN departments d ON e.department_id = d.id
                LEFT JOIN positions p ON e.position_id = p.id
                LEFT JOIN job_profiles jp ON e.id = jp.employee_id
                WHERE e.email = :email LIMIT 1";
        $res = $this->rawQuery($sql, ['email' => $email]);
        return $res[0] ?? null;
    }

    public function findByUser(array $user): ?array {
        if (!empty($user['email'])) {
            $sql = "SELECT e.*, c.name as company_name, d.name as department_name, p.name as position_name,
                           jp.job_type, jp.sitting_hours, jp.standing_hours, jp.computer_hours, jp.shift_type, jp.work_duration
                    FROM employees e
                    LEFT JOIN companies c ON e.company_id = c.id
                    LEFT JOIN departments d ON e.department_id = d.id
                    LEFT JOIN positions p ON e.position_id = p.id
                    LEFT JOIN job_profiles jp ON e.id = jp.employee_id
                    WHERE e.email = :email LIMIT 1";
            $res = $this->rawQuery($sql, ['email' => $user['email']]);
            if (!empty($res[0])) return $res[0];
        }
        if (!empty($user['name'])) {
            $sql = "SELECT e.*, c.name as company_name, d.name as department_name, p.name as position_name,
                           jp.job_type, jp.sitting_hours, jp.standing_hours, jp.computer_hours, jp.shift_type, jp.work_duration
                    FROM employees e
                    LEFT JOIN companies c ON e.company_id = c.id
                    LEFT JOIN departments d ON e.department_id = d.id
                    LEFT JOIN positions p ON e.position_id = p.id
                    LEFT JOIN job_profiles jp ON e.id = jp.employee_id
                    WHERE e.name = :name LIMIT 1";
            $res = $this->rawQuery($sql, ['name' => $user['name']]);
            if (!empty($res[0])) return $res[0];
        }
        return null;
    }
}
