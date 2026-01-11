<?php
// 1. Jalankan Session (WAJIB ADA DI BARIS PALING ATAS)
if(session_status() === PHP_SESSION_NONE) session_start();

// 2. Aktifkan Pesan Error (Supaya ketahuan jika ada kodingan salah)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. Autoloader (Memanggil Class secara otomatis)
spl_autoload_register(function ($class) {
    // Ubah Backslash (\) namespace menjadi Slash (/) direktori
    $class = str_replace('\\', '/', $class);
    
    // Arahkan ke folder app (naik satu level dari public)
    $file = '../app/' . $class . '.php';
    
    // Cek ketersediaan file
    if (file_exists($file)) {
        require_once $file;
    }
});

// 4. Jalankan Aplikasi Utama (Routing)
use Core\App;
$app = new App();