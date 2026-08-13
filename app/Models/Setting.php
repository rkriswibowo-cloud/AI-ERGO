<?php

namespace App\Models;

use Core\Model;

class Setting extends Model {
    protected string $table = 'settings';

    public function getByKey(string $key, string $default = ''): string {
        $res = $this->where('setting_key', $key);
        return $res[0]['setting_value'] ?? $default;
    }

    public function setKey(string $key, string $value, string $group = 'general', string $description = ''): bool {
        $sql = "INSERT INTO settings (setting_group, setting_key, setting_value, description) 
                VALUES (:group, :key, :value, :desc) 
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_group = VALUES(setting_group)";
        return $this->rawExecute($sql, [
            'group' => $group,
            'key' => $key,
            'value' => $value,
            'desc' => $description
        ]);
    }

    public function getAllAsKeyValue(): array {
        $all = $this->all();
        $map = [];
        foreach ($all as $item) {
            $map[$item['setting_key']] = $item['setting_value'];
        }
        return $map;
    }
}
