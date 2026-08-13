<?php

namespace Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/database.php';
            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
            
            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            } catch (PDOException $e) {
                // If database doesn't exist, auto-create it and run schema
                try {
                    $dsnNoDb = "mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}";
                    $pdo = new PDO($dsnNoDb, $config['username'], $config['password'], $config['options']);
                    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . $config['dbname'] . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    $pdo->exec("USE `" . $config['dbname'] . "`");
                    
                    $sqlFile = __DIR__ . '/../database.sql';
                    if (file_exists($sqlFile)) {
                        $sql = file_get_contents($sqlFile);
                        $pdo->exec($sql);
                    }
                    self::$instance = $pdo;
                } catch (PDOException $ex) {
                    die("Database connection error: " . $ex->getMessage());
                }
            }
        }
        return self::$instance;
    }
}
