<?php
// Pengaturan koneksi database
$host = 'localhost';
$user = 'root';
$pass = ''; // Password default di XAMPP
$dbname = 'kuliner_nusantara';

$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
