<?php
// Helper Functions for AI-ERGO System

if (!function_exists('config')) {
    function config($key, $default = null) {
        static $configs = [];
        $parts = explode('.', $key);
        $file = $parts[0];

        if (!isset($configs[$file])) {
            $path = __DIR__ . '/../../config/' . $file . '.php';
            if (file_exists($path)) {
                $configs[$file] = require $path;
            } else {
                $configs[$file] = [];
            }
        }

        $array = $configs[$file];
        for ($i = 1; $i < count($parts); $i++) {
            if (isset($array[$parts[$i]])) {
                $array = $array[$parts[$i]];
            } else {
                return $default;
            }
        }
        return $array;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = '') {
        static $settingsMap = null;
        if ($settingsMap === null) {
            try {
                $settingModel = new \App\Models\Setting();
                $settingsMap = $settingModel->getAllAsKeyValue();
            } catch (\Exception $e) {
                $settingsMap = [];
            }
        }
        return $settingsMap[$key] ?? $default;
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '') {
        static $detectedBase = null;
        if ($detectedBase === null) {
            if (isset($_SERVER['HTTP_HOST'])) {
                $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
                $baseDir = preg_replace('#/public$#i', '', $scriptDir);
                $detectedBase = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim($baseDir, '/');
            } else {
                $detectedBase = config('app.url', 'http://localhost/ergonomi');
            }
        }
        return rtrim($detectedBase, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('assets')) {
    function assets($path = '') {
        static $detectedAssetsBase = null;
        if ($detectedAssetsBase === null) {
            if (isset($_SERVER['HTTP_HOST'])) {
                $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
                if (preg_match('#/public$#i', $scriptDir)) {
                    $detectedAssetsBase = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/') . '/assets/';
                } else {
                    $detectedAssetsBase = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim($scriptDir, '/') . '/public/assets/';
                }
            } else {
                $detectedAssetsBase = base_url('public/assets/');
            }
        }
        return rtrim($detectedAssetsBase, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('upload_url')) {
    function upload_url($path = '') {
        if (empty($path)) return '';
        return base_url('public/' . ltrim($path, '/'));
    }
}

if (!function_exists('upload_exists')) {
    function upload_exists($path = '') {
        if (empty($path)) return false;
        $fullPath = __DIR__ . '/../../public/' . ltrim($path, '/');
        return file_exists($fullPath);
    }
}

if (!function_exists('redirect')) {
    function redirect($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $url = base_url($url);
        }
        header("Location: " . $url);
        exit;
    }
}

if (!function_exists('sanitize')) {
    function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = sanitize($value);
            }
            return $data;
        }
        return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field() {
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('verify_csrf')) {
    function verify_csrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
                http_response_code(403);
                die('CSRF token validation failed.');
            }
        }
    }
}

if (!function_exists('flash')) {
    function flash($key, $message = null, $type = 'success') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($message !== null) {
            $_SESSION['flash'][$key] = [
                'message' => $message,
                'type' => $type
            ];
        } elseif (isset($_SESSION['flash'][$key])) {
            $flash = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $flash;
        }
        return null;
    }
}

if (!function_exists('old')) {
    function old($key, $default = '') {
        return $_SESSION['old_input'][$key] ?? $default;
    }
}

if (!function_exists('auth_user')) {
    function auth_user() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return auth_user() !== null;
    }
}

if (!function_exists('has_role')) {
    function has_role($roleName) {
        $user = auth_user();
        if (!$user) return false;
        if (!isset($user['roles'])) return false;
        return in_array($roleName, (array)$user['roles']);
    }
}

if (!function_exists('risk_badge')) {
    function risk_badge($riskLevel) {
        switch ($riskLevel) {
            case 'Rendah':
                return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Rendah</span>';
            case 'Sedang':
                return '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>Sedang</span>';
            case 'Tinggi':
                return '<span class="badge bg-danger"><i class="fas fa-exclamation-circle me-1"></i>Tinggi</span>';
            case 'Sangat Tinggi':
                return '<span class="badge bg-dark"><i class="fas fa-skull-crossbones me-1"></i>Sangat Tinggi</span>';
            default:
                return '<span class="badge bg-secondary">' . htmlspecialchars($riskLevel) . '</span>';
        }
    }
}
