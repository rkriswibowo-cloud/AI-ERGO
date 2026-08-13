<?php

namespace App\Models;

use Core\Model;

class Department extends Model {
    protected string $table = 'departments';

    public function getWithCompany(): array {
        $sql = "SELECT d.*, c.name as company_name 
                FROM departments d 
                LEFT JOIN companies c ON d.company_id = c.id 
                ORDER BY d.id DESC";
        return $this->rawQuery($sql);
    }
}
