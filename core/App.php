<?php

namespace Core;

class App {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Autoload helper functions
        require_once __DIR__ . '/../app/Helpers/Functions.php';
        
        // Register Autoloader
        spl_autoload_register(function ($class) {
            $prefixCore = 'Core\\';
            $prefixApp = 'App\\';

            if (strpos($class, $prefixCore) === 0) {
                $relativeClass = substr($class, strlen($prefixCore));
                $file = __DIR__ . '/' . str_replace('\\', '/', $relativeClass) . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }

            if (strpos($class, $prefixApp) === 0) {
                $relativeClass = substr($class, strlen($prefixApp));
                $file = __DIR__ . '/../app/' . str_replace('\\', '/', $relativeClass) . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }

    public function run(): void {
        // Load Web Routes
        require_once __DIR__ . '/../routes/web.php';

        // Dispatch HTTP request
        Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
