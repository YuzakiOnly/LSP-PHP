<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

session_start();

$_SESSION['i'] = $_SESSION['i'] ?? 0;
$_SESSION['student'] = $_SESSION['student'] ?? [];

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../routes/web.php';

