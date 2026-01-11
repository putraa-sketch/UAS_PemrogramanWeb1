<?php
namespace Models;
use Config\Database;

class UserModel extends Database {
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users_uas WHERE username = '$username'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
}