<?php

namespace App\Models;

use Core\Model;

class ActivityLog extends Model {
    protected string $table = 'activity_logs';

    public function log(string $module, string $action, string $description = ''): void {
        $userId = auth_user()['id'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        $this->create([
            'user_id' => $userId,
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => $ip,
            'user_agent' => substr($ua, 0, 255)
        ]);
    }

    public function getWithUser(int $limit = 50): array {
        $sql = "SELECT al.*, u.name as user_name, u.email as user_email
                FROM activity_logs al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.id DESC LIMIT {$limit}";
        return $this->rawQuery($sql);
    }

    public function clearAll(): bool {
        return $this->rawExecute("TRUNCATE TABLE activity_logs");
    }
}
