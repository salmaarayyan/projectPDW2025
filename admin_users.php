<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}
include('database.php');

// Alert handler
$alertMsg = '';
$alertType = 'success';

// Handle Create User
if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cek duplikat username
    $cek = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($cek->num_rows > 0) {
        $alertMsg = "Username <b>$username</b> sudah terdaftar!";
        $alertType = "danger";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$passwordHash', '$role')";
        if ($conn->query($sql) === TRUE) {
            $alertMsg = "User berhasil ditambahkan!";
            $alertType = "success";
        } else {
            $alertMsg = "Gagal menambah user!";
            $alertType = "danger";
        }
    }
}

// Handle Update User
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cek duplikat username (kecuali user yang sedang diedit)
    $cek = $conn->query("SELECT * FROM users WHERE username='$username' AND id!=$id");
    if ($cek->num_rows > 0) {
        $alertMsg = "Username <b>$username</b> sudah terdaftar!";
        $alertType = "danger";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username='$username', password='$passwordHash', role='$role' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $alertMsg = "User berhasil diupdate!";
            $alertType = "success";
        } else {
            $alertMsg = "Gagal update user!";
            $alertType = "danger";
        }
    }
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $alertMsg = "User berhasil dihapus!";
        $alertType = "success";
    } else {
        $alertMsg = "Gagal hapus user!";
        $alertType = "danger";
    }
}

// Fetch users from database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Check if there is a user to edit
$editUser = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editUserResult = $conn->query("SELECT * FROM users WHERE id=$id"); // Fetch user data for editing
    $editUser = $editUserResult->fetch_assoc(); // Get user data if exists
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet"> <!-- Poppins Font -->
    <style> /* Custom CSS for the user management page */
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .dashboard-content { margin-left: 240px; padding: 2rem; }
        .form-label, .form-control, .form-select, .table, .btn { font-family: 'Poppins', sans-serif; }
        .btn-primary-custom {
            background-color: #d4841c;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background-color: #b36b13;
            color: #fff;
        }
        .btn-secondary-custom {
            background-color: #fff;
            border: 1.5px solid #d4841c;
            color: #d4841c;
            font-weight: 600;
        }
        .btn-secondary-custom:hover {
            background-color: #d4841c;
            color: #fff;
        }
        .table thead { background: #f3e7d7; }
        .table td, .table th { vertical-align: middle; }
        .alert { font-size: 1rem; }
    </style>
</head>
<body>
    <?php include 'admin_sidebar.php'; ?> <!-- Include sidebar for admin navigation -->
    <div class="dashboard-content"> <!-- Main content for user management -->
        <h2 class="mb-4">User Management</h2>
        <?php if ($alertMsg): ?> <!-- Display alert message if exists -->
            <div class="alert alert-<?php echo $alertType; ?> auto-dismiss-alert" role="alert"> <!-- Alert message -->
                <?php echo $alertMsg; ?> <!-- Display alert message -->
            </div>
        <?php endif; ?> <!-- End of alert message -->
        <div class="card p-4 mb-4 shadow-sm">
            <h5 class="mb-3"><?php echo $editUser ? 'Edit User' : 'Tambah User'; ?></h5>
            <form method="POST" action="admin_users.php" autocomplete="off"> <!-- saat tombol submit ditekan, data akan dikirim (method="POST") ke admin_users.php untuk diproses -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $editUser['username'] ?? ''; ?>" required> <!-- Input untuk username, saat edit user field username otomatis terisi data user yang dipilih -->
                    </div>
                    <div class="col-md-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-4">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin" <?php echo ($editUser && $editUser['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option> <!-- Pilihan role admin, jika user yang diedit adalah admin maka opsi ini akan terpilih -->
                            <option value="user" <?php echo ($editUser && $editUser['role'] == 'user') ? 'selected' : ''; ?>>User</option> <!-- Pilihan role user, jika user yang diedit adalah user maka opsi ini akan terpilih -->
                        </select>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <?php if ($editUser): ?> <!-- Jika sedang mengedit user, tampilkan tombol update -->
                        <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>"> <!-- Hidden input untuk ID user yang sedang diedit -->
                        <button type="submit" name="update" class="btn btn-primary-custom">Update User</button>
                        <a href="admin_users.php" class="btn btn-secondary-custom">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="create" class="btn btn-primary-custom">Tambah User</button> <!-- Tombol untuk menambah user baru -->
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="card p-4 shadow-sm">
            <h5 class="mb-3">Daftar User</h5>
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result->data_seek(0); //-- Reset pointer ke awal hasil query
                    while ($row = $result->fetch_assoc()): ?> <!-- Loop untuk menampilkan daftar user -->
                        <tr>
                            <td><?php echo $row['id']; ?></td> <!-- Tampilkan ID user -->
                            <td><?php echo htmlspecialchars($row['username']); ?></td> <!-- Tampilkan username user -->
                            <td><?php echo ucfirst($row['role']); ?></td> <!-- Tampilkan role user dengan huruf kapital pertama -->
                            <td>
                                <a href="admin_users.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a> <!-- Tombol untuk mengedit user -->
                                <a href="admin_users.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus user ini?')">Hapus</a> <!-- Tombol untuk menghapus user -->
                            </td>
                        </tr>
                    <?php endwhile; ?> <!-- Akhir dari loop daftar user -->
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
    <script>
        setTimeout(function() {
            document.querySelectorAll('.auto-dismiss-alert').forEach(function(el){ <!-- Auto-dismiss alert after 3 seconds -->
                el.style.display = 'none'; <!-- Hide alert elements -->
            });
        }, 3000); // 3 detik
    </script>
</body>
</html>
<?php $conn->close(); ?> <!-- Close database connection -->