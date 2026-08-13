<?php

namespace Core;

class Router {
    private static array $routes = [];

    public static function get(string $path, array $handler): void {
        self::$routes['GET'][$path] = $handler;
    }

    public static function post(string $path, array $handler): void {
        self::$routes['POST'][$path] = $handler;
    }

    public static function dispatch(string $uri, string $method): void {
        // Strip query string
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Normalize directory paths
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $baseDir = preg_replace('#/public$#i', '', $scriptDir);

        if (!empty($scriptDir) && $scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        } elseif (!empty($baseDir) && $baseDir !== '/' && strpos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        }

        if (strpos($uri, '/public/') === 0) {
            $uri = substr($uri, 7);
        } elseif ($uri === '/public') {
            $uri = '/';
        }

        // Clean URI
        $uri = '/' . trim($uri, '/');

        $method = strtoupper($method);

        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $routePath => $handler) {
                // Convert route {param} to regex pattern
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $routePath);
                $pattern = "#^" . $pattern . "$#";

                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches); // Remove full match
                    
                    [$controllerClass, $action] = $handler;
                    
                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $action)) {
                            call_user_func_array([$controller, $action], $matches);
                            return;
                        }
                    }
                }
            }
        }

        // 404 Not Found
        http_response_code(404);
        echo "<!DOCTYPE html><html><head><title>404 Not Found</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'></head><body class='bg-light d-flex align-items-center justify-content-center vh-100'><div class='text-center'><h1>404</h1><p>Halaman tidak ditemukan.</p><a href='" . base_url() . "' class='btn btn-primary'>Kembali ke Beranda</a></div></body></html>";
        exit;
    }
}
