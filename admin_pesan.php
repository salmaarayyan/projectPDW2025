<?php
session_start();
if ($_SESSION['role'] != 'admin') { // Cek apakah user sudah login sebagai admin
    // Jika tidak, redirect ke halaman login
    header('Location: login.php');
    exit();
}
include('database.php');
$pesan = $conn->query("SELECT * FROM pesan ORDER BY tanggal DESC"); // Mengambil semua pesan masuk dari database
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Masuk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <style> /* Custom CSS for the pesan masuk page */
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .dashboard-content { margin-left: 240px; padding: 2rem; }
        .table thead { background: #f3e7d7; }
        .table td, .table th { vertical-align: middle; }
        .card-custom {
            border: 1.5px solid #f3e7d7;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(212,132,28,0.08);
        }
    </style>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?> <!-- Include sidebar for admin navigation -->
    <!-- Main content for pesan masuk -->
    <div class="dashboard-content">
        <h2 class="mb-4" style="font-family:'Poppins',sans-serif;">Pesan Masuk</h2>
        <table class="table table-bordered"> <!-- Table to display incoming messages -->
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while ($row = $pesan->fetch_assoc()): ?> <!-- Loop through each message -->
                <tr>
                    <td><?php echo $no++; ?></td> <!-- Display message number -->
                    <td><?php echo htmlspecialchars($row['nama']); ?></td> <!-- Display sender's name -->
                    <td><?php echo htmlspecialchars($row['email']); ?></td> <!-- Display sender's email -->
                    <td><?php echo nl2br(htmlspecialchars($row['pesan'])); ?></td> <!-- Display message content -->
                    <td><?php echo $row['tanggal']; ?></td> <!-- Display message date -->
                </tr>
                <?php endwhile; ?> <!-- End of message loop -->
                <?php if ($pesan->num_rows == 0): ?> <!-- If no messages are found -->
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada pesan masuk.</td> <!-- Display message if no messages -->
                </tr>
                <?php endif; ?> <!-- End of no messages check -->
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?> <!-- Close database connection -->