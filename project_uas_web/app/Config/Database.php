<?php
namespace Config;
use mysqli;

class Database {
    protected $host = Config::DB_HOST;
    protected $user = Config::DB_USER;
    protected $password = Config::DB_PASS;
    protected $db_name = Config::DB_NAME;
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Koneksi Database Gagal: " . $this->conn->connect_error);
        }
        // Set timezone agar waktu sesuai
        date_default_timezone_set('Asia/Jakarta');
    }

    // 1. Fungsi Query Manual
    public function query($sql) {
        return $this->conn->query($sql);
    }

    // 2. Fungsi Ambil 1 Data (Dipakai di Login & Edit)
    public function get($table, $where = null) {
        if ($where) $where = " WHERE " . $where;
        $sql = "SELECT * FROM " . $table . $where;
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) return $result->fetch_assoc();
        return null;
    }

    // 3. Fungsi Ambil Banyak Data (Dipakai di List Barang)
    public function getAll($table, $where = null, $order = null) {
        $sql = "SELECT * FROM " . $table;
        if ($where) $sql .= " WHERE " . $where;
        if ($order) $sql .= " ORDER BY " . $order;
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) $data[] = $row;
        }
        return $data;
    }

    // 4. Fungsi Insert Data
    public function insert($table, $data) {
        $cols = implode(",", array_keys($data));
        $vals = [];
        foreach($data as $v) $vals[] = "'" . $this->conn->real_escape_string($v) . "'";
        $sql = "INSERT INTO " . $table . " (" . $cols . ") VALUES (" . implode(",", $vals) . ")";
        return $this->conn->query($sql);
    }

    // 5. Fungsi Update Data
    public function update($table, $data, $where) {
        $set = [];
        foreach($data as $k => $v) $set[] = "$k='" . $this->conn->real_escape_string($v) . "'";
        $sql = "UPDATE " . $table . " SET " . implode(",", $set) . " WHERE " . $where;
        return $this->conn->query($sql);
    }

    // 6. Fungsi Delete Data
    public function delete($table, $where) {
        return $this->conn->query("DELETE FROM " . $table . " WHERE " . $where);
    }

    // 7. Fungsi Hitung Data (Pagination)
    public function count($table, $where = null) {
        $sql = "SELECT COUNT(*) as total FROM " . $table;
        if ($where) $sql .= " WHERE " . $where;
        $res = $this->conn->query($sql);
        return $res ? (int)$res->fetch_assoc()['total'] : 0;
    }

    // 8. Fungsi Escape String (Keamanan) - INI YANG ERROR DI VS CODE ANDA TADI
    public function escape($str) {
        return $this->conn->real_escape_string(trim($str));
    }
}