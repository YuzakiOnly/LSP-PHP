<?php

define('APP_NAME', 'Sistem Input Nilai Siswa');
define('BASE_URL', '/');

define('APP_PATH', dirname(__DIR__) . '/app/');
define('PUBLIC_PATH', dirname(__DIR__) . '/public/');
define('VIEW_PATH', APP_PATH . 'Views/');

define('SESSION_NAME', 'student_app');

define('SUBJECTS', [
    'mtk' => 'Matematika',
    'bin' => 'Bahasa Indonesia',
    'big' => 'Bahasa Inggris',
    'pro' => 'Produktif'
]);
