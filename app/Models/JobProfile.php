<?php

namespace App\Models;

use Core\Model;

class JobProfile extends Model {
    protected string $table = 'job_profiles';

    public function findByEmployee(int $employeeId): ?array {
        $sql = "SELECT * FROM job_profiles WHERE employee_id = :emp_id ORDER BY id DESC LIMIT 1";
        $res = $this->rawQuery($sql, ['emp_id' => $employeeId]);
        return $res[0] ?? null;
    }
}
