<?php
// Pastikan tidak ada spasi di atas <?php
if(session_status() === PHP_SESSION_NONE) session_start(); // <--- WAJIB ADA

// Tampilkan Error PHP (Supaya kalau ada error kelihatan)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = '../app/' . $class . '.php';
    if (file_exists($file)) require_once $file;
});

use Core\App;
$app = new App();