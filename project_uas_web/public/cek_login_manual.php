<?php
// FILE: public/cek_login_manual.php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Koneksi Manual (Tanpa Class Config)
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'latihan1';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ Koneksi Database GAGAL: " . $conn->connect_error);
}
echo "✅ Koneksi Database BERHASIL<br><hr>";

// 2. Data yang mau dites
$username_input = 'admin'; // Coba ganti ini sesuai inputan Anda
$password_input = 'password'; // Coba ganti ini sesuai inputan Anda

echo "Testing Login untuk:<br>";
echo "Username: <b>$username_input</b><br>";
echo "Password: <b>$password_input</b><br><hr>";

// 3. Cek Query
$sql = "SELECT * FROM users_uas WHERE username = '$username_input'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo "✅ User DITEMUKAN di Database!<br>";
    echo "Hash di DB: " . $data['password'] . "<br><br>";

    // 4. Cek Password
    if (password_verify($password_input, $data['password'])) {
        echo "✅ <h1 style='color:green'>PASSWORD COCOK!</h1>";
        echo "Artinya: Username & Password Anda BENAR.<br>";
        echo "Masalahnya kemungkinan ada di file <b>AuthController.php</b> atau <b>Session</b> tidak tersimpan.";
        
        // Cek Session Path
        echo "<br><br>Info Session Save Path: " . session_save_path();
        echo "<br>Status Session Write: " . (is_writable(session_save_path()) ? 'Writable (Bisa ditulis)' : 'Not Writable (Error Permission)');
        
    } else {
        echo "❌ <h1 style='color:red'>PASSWORD SALAH!</h1>";
        echo "Artinya: Hash di database tidak cocok dengan kata sandi '$password_input'.<br>";
        echo "Solusi: Reset user di database.";
    }
} else {
    echo "❌ User TIDAK DITEMUKAN di tabel users_uas.<br>";
}
?>