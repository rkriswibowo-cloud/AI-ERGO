<?php

namespace App\Models;

use Core\Model;

class User extends Model {
    protected string $table = 'users';

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT u.*, c.name as company_name 
                                    FROM users u 
                                    LEFT JOIN companies c ON u.company_id = c.id 
                                    WHERE u.email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function getUserRoles(int $userId): array {
        $sql = "SELECT r.name 
                FROM user_roles ur 
                JOIN roles r ON ur.role_id = r.id 
                WHERE ur.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getWithDetails(): array {
        $sql = "SELECT u.*, c.name as company_name, GROUP_CONCAT(r.name SEPARATOR ', ') as role_names
                FROM users u
                LEFT JOIN companies c ON u.company_id = c.id
                LEFT JOIN user_roles ur ON u.id = ur.user_id
                LEFT JOIN roles r ON ur.role_id = r.id
                GROUP BY u.id
                ORDER BY u.id DESC";
        return $this->rawQuery($sql);
    }

    public function assignRole(int $userId, int $roleId): bool {
        $sql = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id) 
                ON DUPLICATE KEY UPDATE role_id = :role_id";
        return $this->rawExecute($sql, ['user_id' => $userId, 'role_id' => $roleId]);
    }
}
