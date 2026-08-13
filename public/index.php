<?php
// AI-ERGO Front Controller Entry Point

require_once __DIR__ . '/../core/App.php';

$app = new Core\App();
$app->run();
