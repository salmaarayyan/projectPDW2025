<?php
// Contoh password yang ingin Anda masukkan
$password = 'user123';

// Hash password menggunakan password_hash()
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo $hashed_password; // Salin hasil hash password ini
?>
