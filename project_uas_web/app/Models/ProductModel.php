<?php
namespace Models;
use Config\Database;

class ProductModel {
    private $table = 'data_barang';
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database di sini
        $this->db = new Database();
    }

    public function getAll($keyword, $limit, $offset) {
        $where = null;
        if ($keyword) {
            // Panggil escape dari object $this->db
            $keyword = $this->db->escape($keyword);
            $where = "nama LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
        }
        $order = "id_barang DESC LIMIT $offset, $limit";
        
        // Panggil getAll dari object $this->db
        return $this->db->getAll($this->table, $where, $order);
    }

    public function countAll($keyword) {
        $where = null;
        if ($keyword) {
            $keyword = $this->db->escape($keyword);
            $where = "nama LIKE '%$keyword%' OR kategori LIKE '%$keyword%'";
        }
        return $this->db->count($this->table, $where);
    }

    public function getById($id) {
        $id = $this->db->escape($id);
        return $this->db->get($this->table, "id_barang='$id'");
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $id = $this->db->escape($id);
        return $this->db->update($this->table, $data, "id_barang='$id'");
    }

    public function delete($id) {
        $id = $this->db->escape($id);
        return $this->db->delete($this->table, "id_barang='$id'");
    }
}