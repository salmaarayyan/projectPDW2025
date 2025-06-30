<?php
include '../database.php';

// Proses form pesan
$alertMsg = '';
$alertType = 'success';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];
    if ($conn->query("INSERT INTO pesan (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')")) {
        $alertMsg = "Terima kasih, <b>$nama</b>! Pesanmu sudah masuk ke admin.";
        $alertType = "success";
    } else {
        $alertMsg = "Pesan gagal dikirim!";
        $alertType = "danger";
    }
}

// Ambil data tim dari database
$team = $conn->query("SELECT * FROM team");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            background-color: #f8f9fa;
        }
        .card-custom {
            border: 1px solid #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background: #fff;
            transition: box-shadow 0.2s;
            height: 100%;
        }
        .card-custom:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }
        .team-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .contact-icon {
            width: 28px;
            margin-right: 10px;
            opacity: 0.8;
        }
        .form-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 24px;
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <nav class="navbar navbar-expand-lg" style="background-color:#d4841c;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">Kuliner Nusantara</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="daerah.html">Daerah</a></li>
                    <li class="nav-item"><a class="nav-link active" href="tentang.php">Tentang</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Tombol Back -->
    <div class="container mt-4">
        <button class="btn btn-outline-secondary mb-3" onclick="window.history.back()">
            &larr; Kembali
        </button>
    </div>

    <div class="container pb-5">
        <h2 class="mb-4 text-center">Tentang Kami</h2>
        <div class="row g-4 mb-4">
            <!-- Visi -->
            <div class="col-md-6">
                <div class="card-custom p-4 h-100">
                    <h4 class="mb-3 text-primary">Visi</h4>
                    <p>Menjadi platform kuliner Nusantara terdepan yang menginspirasi dan memperkenalkan kekayaan rasa Indonesia ke seluruh dunia.</p>
                </div>
            </div>
            <!-- Misi -->
            <div class="col-md-6">
                <div class="card-custom p-4 h-100">
                    <h4 class="mb-3 text-success">Misi</h4>
                    <ul>
                        <li>Menyajikan informasi kuliner Nusantara yang akurat dan menarik.</li>
                        <li>Mendukung UMKM dan pelaku kuliner lokal.</li>
                        <li>Mengedukasi masyarakat tentang keberagaman makanan Indonesia.</li>
                        <li>Mengutamakan pelayanan dan pengalaman pengguna terbaik.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tim Kami -->
        <h3 class="mb-3 text-center">Tim Kami</h3>
        <div class="row g-4 mb-4 justify-content-center">
            <?php while ($row = $team->fetch_assoc()): ?>
            <div class="col-md-3 col-6">
                <div class="card-custom text-center p-3">
                    <img src="../image/<?php echo htmlspecialchars($row['foto']); ?>" class="team-img" alt="<?php echo htmlspecialchars($row['nama']); ?>">
                    <h6 class="mb-0"><?php echo htmlspecialchars($row['nama']); ?></h6>
                    <small class="text-muted"><?php echo htmlspecialchars($row['jabatan']); ?></small>
                </div>
            </div>
            <?php endwhile; ?>
            <?php if ($team->num_rows == 0): ?>
            <div class="col-12 text-center text-muted">Belum ada data tim.</div>
            <?php endif; ?>
        </div>

        <!-- Komitmen Kami -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="alert alert-info text-center fs-5">
                    Kami berkomitmen untuk selalu memberikan pelayanan terbaik, menjaga kepercayaan pelanggan, dan terus berkembang bersama Anda.
                </div>
            </div>
        </div>

        <!-- Kontak Kami -->
        <h3 class="mb-3 text-center">Kontak Kami</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card-custom p-4 h-100">
                    <ul class="list-unstyled mb-3">
                        <li class="mb-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" class="contact-icon" alt="Alamat">
                            <strong>Alamat:</strong> UMY, Yogyakarta
                        </li>
                        <li class="mb-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/724/724664.png" class="contact-icon" alt="Telepon">
                            <strong>Telepon:</strong> (+62)0123456789
                        </li>
                        <li class="mb-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" class="contact-icon" alt="Email">
                            <strong>Email:</strong> pdwgroup3@mail.com
                        </li>
                        <li class="mb-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828884.png" class="contact-icon" alt="Jam">
                            <strong>Jam Operasional:</strong> Senin - Jumat, 08.00 - 17.00 WIB
                        </li>
                        <li class="mb-2">
                            <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" class="contact-icon" alt="Instagram">
                            <strong>Instagram:</strong> <a href="https://instagram.com/akuncontoh" target="_blank">@group3keren</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-section h-100" id="form-pesan">
                    <h5 class="mb-3">Kirim Pesan ke Kami</h5>
                    <?php if ($alertMsg): ?>
                        <div class="alert alert-<?php echo $alertType; ?> auto-dismiss-alert" role="alert">
                            <?php echo $alertMsg; ?>
                        </div>
                    <?php endif; ?>
                    <form action="proses_pesan.php" method="post">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            document.querySelectorAll('.auto-dismiss-alert').forEach(function(el){
                el.style.display = 'none';
            });
        }, 3000); // 3 detik
    </script>
    <script>
    setTimeout(function() {
        document.querySelectorAll('.auto-dismiss-alert').forEach(function(el){
            el.style.display = 'none';
        });
    }, 3000);

    // Scroll ke form/alert jika ada alert
    window.onload = function() {
        var alertBox = document.querySelector('.auto-dismiss-alert');
        if(alertBox) {
            document.getElementById('form-pesan').scrollIntoView({behavior: "smooth"});
        }
    }
</script>
</body>
</html>
<?php $conn->close(); ?>