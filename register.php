<?php
session_start();
$message = ''; // Variabel untuk menyimpan pesan keberhasilan atau kegagalan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic Validation
    if (empty($username) || empty($password)) {
        $message = '<p class="message-error">Username dan password tidak boleh kosong!</p>';
    } elseif (strlen($password) < 6) {
        $message = '<p class="message-error">Password minimal 6 karakter!</p>';
    } else {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Koneksi ke database
        $conn = new mysqli('localhost', 'root', '', 'kuliner_nusantara');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Cek apakah username sudah ada
        $check_sql = "SELECT username FROM users WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = '<p class="message-error">Username sudah terdaftar. Silakan gunakan username lain.</p>';
        } else {
            // Query untuk memasukkan data pengguna ke tabel
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $role = 'user'; // Role default
            $stmt->bind_param("sss", $username, $hashed_password, $role);

            if ($stmt->execute()) {
                $message = '<p class="message-success">Pendaftaran berhasil! Silakan <a href="login.php">Masuk</a>.</p>';
            } else {
                $message = '<p class="message-error">Pendaftaran gagal. Silakan coba lagi.</p>';
            }
        }

        if (isset($check_stmt)) $check_stmt->close();
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Kuliner Nusantara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + Google Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }

        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #34495e;
        }

        .auth-tabs a {
            flex: 1;
            padding: 0.6rem 0;
            border-radius: 30px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            background: #f0f2f5;
        }

        .auth-tabs a.active {
            background: #007bff;
            color: white;
        }

        .auth-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-auth {
            background-color: #007bff;
            color: white;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-auth:hover {
            background-color: #0056b3;
        }

        .message-error {
            background: #f8d7da;
            color: #721c24;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-tabs">
            <a href="register.php" class="active">Daftar</a>
            <a href="login.php">Login</a>
        </div>

        <h2 class="auth-title">Form Register</h2>

        <?php echo $message; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-auth">Daftar</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="login.php">Login sekarang</a>
        </div>
    </div>
</body>
</html>