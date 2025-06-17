<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $pesan = htmlspecialchars($_POST["pesan"]);
    // Di sini kamu bisa menambahkan proses simpan ke database atau kirim email

    echo "<!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Pesan Terkirim</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='bg-light'>
        <div class='container mt-5'>
            <div class='alert alert-success'>
                <h4 class='alert-heading'>Terima kasih, $nama!</h4>
                <p>Pesan kamu sudah kami terima.<br>
                Kami akan segera menghubungi ke email <strong>$email</strong>.</p>
                <hr>
                <a href='tentang.html' class='btn btn-primary'>Kembali ke Tentang Kami</a>
            </div>
        </div>
    </body>
    </html>";
} else {
    header("Location: tentang.html");
    exit;
}
?>