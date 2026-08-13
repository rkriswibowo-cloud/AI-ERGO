<?php

namespace App\Models;

use Core\Model;

class Position extends Model {
    protected string $table = 'positions';

    public function getWithCompany(): array {
        $sql = "SELECT p.*, c.name as company_name 
                FROM positions p 
                LEFT JOIN companies c ON p.company_id = c.id 
                ORDER BY p.id DESC";
        return $this->rawQuery($sql);
    }
}
