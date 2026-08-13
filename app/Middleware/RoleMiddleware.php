<?php

namespace App\Middleware;

class RoleMiddleware {
    public static function check(array $allowedRoles): void {
        AuthMiddleware::check();
        
        $user = auth_user();
        $userRoles = $user['roles'] ?? [];

        $hasAccess = false;
        foreach ($allowedRoles as $role) {
            if (in_array($role, $userRoles)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            flash('error', 'Anda tidak memiliki hak akses ke halaman ini.', 'danger');
            redirect('dashboard');
        }
    }
}
