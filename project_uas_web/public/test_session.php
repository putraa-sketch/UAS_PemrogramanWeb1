<?php
session_start();
$_SESSION['test'] = 'berhasil';
echo "Session Test: " . $_SESSION['test'];
echo "<br>Session ID: " . session_id();
echo "<br>Session Save Path: " . session_save_path();
echo "<br>Writable: " . (is_writable(session_save_path()) ? 'YES' : 'NO');
?>