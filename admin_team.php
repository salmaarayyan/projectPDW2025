<?php
session_start();
if ($_SESSION['role'] != 'admin') { // Cek apakah user sudah login sebagai admin
    // Jika tidak, redirect ke halaman login
    header('Location: login.php');
    exit();
}
include('database.php'); // Menghubungkan ke database

// Untuk menampung pesan alert
$alertMsg = '';
$alertType = 'success';

// Handle Create Team
if (isset($_POST['create'])) {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $fotoName = $_FILES['foto']['name'];
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $target = "image/" . basename($fotoName);

    if (move_uploaded_file($fotoTmp, $target)) {
        $sql = "INSERT INTO team (nama, jabatan, foto) VALUES ('$nama', '$jabatan', '$fotoName')";
        $conn->query($sql);
        $alertMsg = "Anggota tim berhasil ditambahkan!";
        $alertType = "success";
    } else {
        $alertMsg = "Gagal upload foto.";
        $alertType = "danger";
    }
}

// Handle Update Team
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $fotoName = $_FILES['foto']['name'];
    $updateFoto = "";

    if ($fotoName) {
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $target = "image/" . basename($fotoName);
        if (move_uploaded_file($fotoTmp, $target)) {
            $updateFoto = ", foto='$fotoName'";
        }
    }
    $sql = "UPDATE team SET nama='$nama', jabatan='$jabatan' $updateFoto WHERE id=$id";
    $conn->query($sql);
    $alertMsg = "Data tim berhasil diupdate!";
    $alertType = "success";
}

// Handle Delete Team
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Cek apakah data ada
    $fotoRow = $conn->query("SELECT foto FROM team WHERE id=$id")->fetch_assoc();
    if ($fotoRow) {
        $foto = $fotoRow['foto'];
        if ($foto && file_exists("image/$foto")) {
            unlink("image/$foto");
        }
        $conn->query("DELETE FROM team WHERE id=$id");
        $alertMsg = "Data tim berhasil dihapus!";
        $alertType = "success";
    }
}

// Fetch Team dari database
$team = $conn->query("SELECT * FROM team");

// Cek apakah ada tim yang sedang diedit
$editTeam = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editTeam = $conn->query("SELECT * FROM team WHERE id=$id")->fetch_assoc(); // Ambil data tim untuk diedit
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tim Kami - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet"> <!-- Poppins Font -->
    <style> /* Custom CSS for the admin team management */
        body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .dashboard-content { margin-left: 240px; padding: 2rem; }
        .team-img { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; }
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
    <!-- Main content for managing team -->
    <div class="dashboard-content">
        <h2 class="mb-4" style="font-family:'Poppins',sans-serif;">Tim Kami</h2>
        <?php if ($alertMsg): ?> <!-- Display alert message if exists -->
            <div class="alert alert-<?php echo $alertType; ?> auto-dismiss-alert" role="alert"> <!-- Alert message -->
                <?php echo $alertMsg; ?> <!-- Display alert message -->
            </div>
        <?php endif; ?> <!-- End of alert message -->
        <form method="POST" action="admin_team.php" enctype="multipart/form-data" class="mb-4"> <!-- Form to add or edit team member -->
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $editTeam['nama'] ?? ''; ?>" required> <!-- Input for team member name -->
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="<?php echo $editTeam['jabatan'] ?? ''; ?>" required> <!-- Input for team member position -->
            </div>
            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" <?php echo $editTeam ? '' : 'required'; ?>> <!-- Input for team member photo -->
                <?php if ($editTeam && $editTeam['foto']): ?> <!-- Display existing photo if editing -->
                    <img src="image/<?php echo $editTeam['foto']; ?>" class="team-img mt-2"> <!-- Show existing photo -->
                <?php endif; ?> <!-- End of existing photo check -->
            </div>
            <div class="d-flex gap-2">
            <?php if ($editTeam): ?> <!-- If editing, show update button -->
                <input type="hidden" name="id" value="<?php echo $editTeam['id']; ?>"> <!-- Hidden input for team member ID -->
                <button type="submit" name="update" class="btn btn-primary-custom">Update</button>
                <a href="admin_team.php" class="btn btn-secondary-custom">Batal</a>
            <?php else: ?>
                <button type="submit" name="create" class="btn btn-primary-custom">Tambah</button> <!-- Button to add new team member -->
            <?php endif; ?>
            </div>
        </form>
        <h4>Daftar Tim</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $team->fetch_assoc()): ?> <!-- Loop through each team member -->
                <tr>
                    <td>
                        <?php if ($row['foto']): ?> <!-- If photo exists, display it -->
                            <img src="image/<?php echo $row['foto']; ?>" class="team-img"> <!-- Show team member photo -->
                        <?php endif; ?> <!-- End of photo check -->
                    </td>
                    <td><?php echo $row['nama']; ?></td> <!-- Display team member name -->
                    <td><?php echo $row['jabatan']; ?></td> <!-- Display team member position -->
                    <td>
                        <a href="admin_team.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a> <!-- Button to edit team member -->
                        <a href="admin_team.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a> <!-- Button to delete team member -->
                    </td>
                </tr>
                <?php endwhile; ?> <!-- End of team member loop -->
            </tbody>
        </table>
    </div>
    <script>
        setTimeout(function() { <!-- Auto-dismiss alert after 3 seconds -->
            document.querySelectorAll('.auto-dismiss-alert').forEach(function(el){ <!-- Select all alert elements -->
                el.style.display = 'none'; <!-- Hide alert elements -->
            });
        }, 3000);
    </script>
</body>
</html>
<?php $conn->close(); ?> <!-- Close database connection -->