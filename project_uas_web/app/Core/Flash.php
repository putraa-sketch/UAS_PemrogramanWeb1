<?php
namespace Core;

class Flash {
    // Set flash message
    public static function set($key, $message, $type = 'info') {
        $_SESSION['flash'][$key] = [
            'message' => $message,
            'type' => $type
        ];
    }

    // Get and remove flash message
    public static function get($key) {
        if (isset($_SESSION['flash'][$key])) {
            $flash = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $flash;
        }
        return null;
    }

    // Check if flash exists
    public static function has($key) {
        return isset($_SESSION['flash'][$key]);
    }

    // Display flash message
    public static function display($key = 'message') {
        if (self::has($key)) {
            $flash = self::get($key);
            $icon = [
                'success' => '✅',
                'error' => '❌',
                'warning' => '⚠️',
                'info' => 'ℹ️'
            ];
            
            echo '<div class="alert alert-' . $flash['type'] . ' alert-dismissible fade show" role="alert">';
            echo ($icon[$flash['type']] ?? '') . ' ' . htmlspecialchars($flash['message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            echo '</div>';
        }
    }
}