<?php
session_start();
session_destroy(); // Hapus sesi pengguna
header('Location: login.php'); // Arahkan ke halaman login
exit();
?>
