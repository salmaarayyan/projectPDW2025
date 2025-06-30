<?php
session_start(); // Mulai sesi
session_destroy(); // Hapus sesi pengguna
header('Location: login.php'); // Arahkan ke halaman login
exit();
?>
