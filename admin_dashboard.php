<?php
session_start();
if ($_SESSION['role'] != 'admin') { // Cek apakah user sudah login sebagai admin
    // Jika tidak, redirect ke halaman login
    header('Location: login.php');
    exit();
}
include('database.php'); // Menghubungkan ke database

//Menjalankan query SQL untuk menghitung total baris
$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0]; // Menghitung jumlah user
$teamCount = $conn->query("SELECT COUNT(*) FROM team")->fetch_row()[0]; // Menghitung jumlah tim
$pesanCount = $conn->query("SELECT COUNT(*) FROM pesan")->fetch_row()[0]; // Menghitung jumlah pesan masuk
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">  <!-- Poppins Font -->
    <style> /* Custom CSS for the admin dashboard */
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .dashboard-content { margin-left: 240px; padding: 2rem; }
        .card-stat {
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(212,132,28,0.08);
            border: 1.5px solid #f3e7d7;
            background: #fff;
        }
        .card-stat h5 { color: #d4841c; font-weight: 600; }
        .card-stat .fw-bold { color: #222; }
    </style>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?> <!-- Include sidebar for admin navigation -->
    <!-- Main dashboard content -->
    <div class="dashboard-content">
        <h2 class="mb-4" style="font-family:'Poppins',sans-serif;">Dashboard</h2>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-stat shadow-sm p-4">
                    <h5>Total Users</h5>
                    <h2 class="fw-bold"><?php echo $userCount; ?></h2> <!-- Display total users -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat shadow-sm p-4">
                    <h5>Total Tim</h5>
                    <h2 class="fw-bold"><?php echo $teamCount; ?></h2> <!-- Display total team members -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat shadow-sm p-4">
                    <h5>Pesan Masuk</h5>
                    <h2 class="fw-bold"><?php echo $pesanCount; ?></h2> <!-- Display total incoming messages -->
                </div>
            </div>
        </div>
        <p>Selamat datang di halaman admin. Silakan pilih menu di sidebar untuk mengelola data.</p>
    </div>
</body>
</html>
<?php $conn->close(); ?> <!-- Tutup koneksi database -->