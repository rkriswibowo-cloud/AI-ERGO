<?php

namespace App\Middleware;

class AuthMiddleware {
    public static function check(): void {
        if (!is_logged_in()) {
            flash('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.', 'danger');
            redirect('auth/login');
        }
    }
}
