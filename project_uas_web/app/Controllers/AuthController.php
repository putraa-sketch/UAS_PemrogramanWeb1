<?php
namespace Controllers;
use Core\Controller;
use Config\Database;
use Config\Config;

class AuthController extends Controller {
    public function index() {
        // Cek apakah sudah login
        if(isset($_SESSION['user_id'])) {
            header('Location: ' . Config::BASE_URL . '/barang'); // Redirect ke Dashboard
            exit;
        }
        $this->view('auth/login');
    }

    public function login() {
        // Cek apakah form di-submit
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . Config::BASE_URL . '/auth');
            exit;
        }

        $db = new Database();
        
        // Ambil input dan validasi
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        // Validasi input kosong
        if(empty($username) || empty($password)) {
            header('Location: ' . Config::BASE_URL . '/auth?error=empty');
            exit;
        }

        // Escape untuk keamanan
        $username = $db->escape($username);

        // Cari user di database
        $user = $db->get('users_uas', "username = '$username'");

        // Debug: Uncomment baris di bawah untuk testing
        // echo "<pre>"; print_r($user); die();

        if ($user && password_verify($password, $user['password'])) {
            // LOGIN SUKSES
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Regenerate session ID untuk keamanan
            session_regenerate_id(true);
            
            // Redirect ke halaman barang
            // Gunakan absolute path untuk memastikan redirect bekerja
            $redirect = Config::BASE_URL . '/barang';
            header('Location: ' . $redirect);
            exit;
        } else {
            // LOGIN GAGAL
            header('Location: ' . Config::BASE_URL . '/auth?error=invalid');
            exit;
        }
    }

    public function logout() {
        // Hapus semua session
        $_SESSION = array();
        
        // Hapus cookie session jika ada
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        // Destroy session
        session_destroy();
        
        // Redirect ke login
        header('Location: ' . Config::BASE_URL . '/auth');
        exit;
    }
}