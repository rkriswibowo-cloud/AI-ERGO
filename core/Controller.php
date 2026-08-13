<?php

namespace Core;

abstract class Controller {

    protected function view(string $viewPath, array $data = [], ?string $layout = 'layouts/header') {
        extract($data);
        
        // Convert dot notation view path to filesystem path (e.g. auth.login -> auth/login)
        $viewFile = str_replace('.', '/', $viewPath);
        $fullPath = __DIR__ . '/../resources/views/' . $viewFile . '.php';

        if (!file_exists($fullPath)) {
            die("View file not found: " . $viewFile);
        }

        // Render header layout if layout specified
        if ($layout) {
            $headerPath = __DIR__ . '/../resources/views/layouts/header.php';
            $sidebarPath = __DIR__ . '/../resources/views/layouts/sidebar.php';
            if (file_exists($headerPath)) {
                require $headerPath;
            }
            if (file_exists($sidebarPath) && is_logged_in()) {
                require $sidebarPath;
            }
        }

        require $fullPath;

        if ($layout) {
            $footerPath = __DIR__ . '/../resources/views/layouts/footer.php';
            if (file_exists($footerPath)) {
                require $footerPath;
            }
        }
    }

    protected function json($data, int $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url) {
        redirect($url);
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function input(string $key = null, $default = null) {
        if ($key === null) {
            return sanitize($_REQUEST);
        }
        return isset($_REQUEST[$key]) ? sanitize($_REQUEST[$key]) : $default;
    }
}
