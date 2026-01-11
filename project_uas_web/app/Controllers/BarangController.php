<?php
namespace Controllers;
use Core\Controller;
use Config\Config;
use Config\Database;

class BarangController extends Controller {
    public function __construct() {
        // Proteksi: harus login dulu
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . Config::BASE_URL . '/auth');
            exit;
        }
    }

    // HALAMAN DASHBOARD (Statistik Aja)
    public function index() {
        $data['title'] = "Dashboard";
        
        // Hitung Statistik (untuk semua user)
        $db = new Database();
        
        // Total jenis barang
        $data['total_barang'] = $db->count('data_barang');
        
        // Total stok semua barang
        $result_stok = $db->query("SELECT SUM(stok) as total FROM data_barang");
        $data['total_stok'] = $result_stok ? (int)$result_stok->fetch_assoc()['total'] : 0;
        
        // Total nilai inventory (harga_jual * stok)
        $result_nilai = $db->query("SELECT SUM(harga_jual * stok) as total FROM data_barang");
        $data['total_nilai'] = $result_nilai ? (float)$result_nilai->fetch_assoc()['total'] : 0;
        
        // Barang dengan stok habis
        $data['stok_habis'] = $db->count('data_barang', 'stok = 0');
        
        // Barang dengan stok menipis (kurang dari 5)
        $data['stok_menipis'] = $db->count('data_barang', 'stok > 0 AND stok < 5');
        
        // Kategori terbanyak
        $result_kategori = $db->query("SELECT kategori, COUNT(*) as total FROM data_barang GROUP BY kategori ORDER BY total DESC LIMIT 1");
        $data['kategori_terbanyak'] = $result_kategori ? $result_kategori->fetch_assoc() : null;
        
        // Top 5 Barang dengan Stok Terbanyak
        $data['top_barang'] = $db->getAll('data_barang', null, 'stok DESC LIMIT 5');
        
        // Barang yang Perlu Restock
        $data['perlu_restock'] = $db->getAll('data_barang', 'stok < 5', 'stok ASC LIMIT 5');

        // Render View Dashboard
        $this->view('templates/header', $data);
        $this->view('admin/home', $data); // Halaman Dashboard
        $this->view('templates/footer');
    }

    // HALAMAN LIST DATA BARANG (Tabel)
    public function list() {
        $q = isset($_GET['q']) ? $_GET['q'] : "";
        $hal = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
        $limit = 5;
        $offset = ($hal - 1) * $limit;

        $model = $this->model('ProductModel');
        $data['barang'] = $model->getAll($q, $limit, $offset);
        $total = $model->countAll($q);
        
        $data['q'] = $q;
        $data['hal'] = $hal;
        $data['pages'] = ceil($total / $limit);
        $data['title'] = "Data Barang";

        // Render View List Barang
        $this->view('templates/header', $data);
        $this->view('admin/list', $data); // Halaman List Barang
        $this->view('templates/footer');
    }

    public function create() {
        // Hanya admin yang bisa tambah
        if($_SESSION['role'] != 'admin') {
            die("Akses Ditolak! Hanya Admin yang dapat menambah barang.");
        }
        
        $data['title'] = "Tambah Barang";
        $data['action'] = Config::BASE_URL . '/barang/store';
        $data['item'] = []; // Data kosong untuk form tambah
        
        // Render View Form
        $this->view('templates/header', $data);
        $this->view('admin/form', $data);
        $this->view('templates/footer');
    }

    public function store() {
        // Cek apakah form di-submit
        if(!isset($_POST['submit'])) {
            header('Location: '.Config::BASE_URL.'/barang/list');
            exit;
        }

        // Cek role admin
        if($_SESSION['role'] != 'admin') {
            die("Akses Ditolak!");
        }

        // Proses upload gambar
        $gambar = null;
        if(isset($_FILES['file_gambar']) && $_FILES['file_gambar']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['file_gambar']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if(in_array($ext, $allowed)) {
                $newname = time() . '_' . $filename;
                $upload_path = __DIR__ . '/../../public/gambar/' . $newname;
                
                // Pastikan folder gambar ada
                if(!is_dir(__DIR__ . '/../../public/gambar/')) {
                    mkdir(__DIR__ . '/../../public/gambar/', 0777, true);
                }
                
                if(move_uploaded_file($_FILES['file_gambar']['tmp_name'], $upload_path)) {
                    $gambar = 'gambar/' . $newname;
                }
            }
        }
        
        // Insert data
        $result = $this->model('ProductModel')->insert([
            'nama' => $_POST['nama'],
            'kategori' => $_POST['kategori'],
            'harga_beli' => $_POST['harga_beli'],
            'harga_jual' => $_POST['harga_jual'],
            'stok' => $_POST['stok'],
            'gambar' => $gambar
        ]);
        
        if($result) {
            \Core\Flash::set('message', 'Data barang berhasil ditambahkan!', 'success');
        } else {
            \Core\Flash::set('message', 'Gagal menambahkan data barang!', 'error');
        }
        
        header('Location: '.Config::BASE_URL.'/barang/list');
        exit;
    }

    public function edit($id) {
        if($_SESSION['role'] != 'admin') {
            die("Akses Ditolak! Hanya Admin yang dapat mengedit barang.");
        }
        
        $data['title'] = "Edit Barang";
        $data['action'] = Config::BASE_URL . '/barang/update/' . $id;
        $data['item'] = $this->model('ProductModel')->getById($id);

        if(!$data['item']) {
            die("Data tidak ditemukan!");
        }

        $this->view('templates/header', $data);
        $this->view('admin/form', $data);
        $this->view('templates/footer');
    }

    public function update($id) {
        if(!isset($_POST['submit'])) {
            header('Location: '.Config::BASE_URL.'/barang/list');
            exit;
        }

        if($_SESSION['role'] != 'admin') {
            die("Akses Ditolak!");
        }

        $model = $this->model('ProductModel');
        $old = $model->getById($id);
        $gambar = $old['gambar'];

        // Proses upload gambar baru
        if(isset($_FILES['file_gambar']) && $_FILES['file_gambar']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['file_gambar']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if(in_array($ext, $allowed)) {
                $newname = time() . '_' . $filename;
                $upload_path = __DIR__ . '/../../public/gambar/' . $newname;
                
                if(move_uploaded_file($_FILES['file_gambar']['tmp_name'], $upload_path)) {
                    // Hapus gambar lama jika ada
                    if($old['gambar'] && file_exists(__DIR__ . '/../../public/' . $old['gambar'])) {
                        unlink(__DIR__ . '/../../public/' . $old['gambar']);
                    }
                    $gambar = 'gambar/' . $newname;
                }
            }
        }

        $model->update($id, [
            'nama' => $_POST['nama'],
            'kategori' => $_POST['kategori'],
            'harga_beli' => $_POST['harga_beli'],
            'harga_jual' => $_POST['harga_jual'],
            'stok' => $_POST['stok'],
            'gambar' => $gambar
        ]);
        
        \Core\Flash::set('message', 'Data barang berhasil diupdate!', 'success');
        
        header('Location: '.Config::BASE_URL.'/barang/list');
        exit;
    }

    public function delete($id) {
        if($_SESSION['role'] != 'admin') {
            die("Akses Ditolak!");
        }
        
        // Hapus gambar jika ada
        $model = $this->model('ProductModel');
        $item = $model->getById($id);
        if($item && $item['gambar']) {
            $file = __DIR__ . '/../../public/' . $item['gambar'];
            if(file_exists($file)) {
                unlink($file);
            }
        }
        
        $model->delete($id);
        \Core\Flash::set('message', 'Data barang berhasil dihapus!', 'success');
        
        header('Location: '.Config::BASE_URL.'/barang/list');
        exit;
    }
}