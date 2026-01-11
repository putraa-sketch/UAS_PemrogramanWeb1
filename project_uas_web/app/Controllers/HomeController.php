<?php
namespace Controllers;
use Core\Controller;
use Config\Config;

class HomeController extends Controller {
    public function index() {
        // Redirect ke barang saja
        header('Location: ' . Config::BASE_URL . '/barang');
    }
}