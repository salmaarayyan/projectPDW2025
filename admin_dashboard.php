<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php'); // Arahkan ke login jika bukan admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuliner Nusantara</title>
    <meta name="description" content="Jelajahi resep masakan tradisional Indonesia dari berbagai daerah. Temukan kekayaan kuliner nusantara dari Sabang sampai Merauke.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #d4821a;
            --secondary-color: #8b4513;
            --accent-color: #ff6b35;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--bg-light); }
        .admin-label {
            background: #d4821a;
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-left: 10px;
        }
        .btn-crud { margin-right: 5px; margin-bottom: 5px; }
        .region-card, .recipe-card {
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 15px;
            background: #fff;
            margin-bottom: 2rem;
        }
        .region-card img, .recipe-card img {
            border-radius: 15px 15px 0 0;
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .region-info, .recipe-info {
            padding: 1.2rem;
        }
        .btn-crud-group {
            margin-top: 10px;
        }
        /* ...tambahkan style lain dari index jika perlu... */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://i.pinimg.com/736x/2d/95/88/2d9588e8b5b8c89c5d5a2c2b7e2a8f5c.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero-title { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem; }
        .hero-subtitle { font-size: 1.3rem; margin-bottom: 2rem; opacity: 0.9; }
        .btn-primary-custom {
            background: var(--primary-color);
            border: 2px solid var(--primary-color);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin: 0 0.5rem;
        }
        .btn-primary-custom:hover {
            background: transparent;
            color: var(--primary-color);
        }
        .btn-secondary-custom {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin: 0 0.5rem;
        }
        .btn-secondary-custom:hover {
            background: white;
            color: var(--text-dark);
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--text-dark);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#d4821a;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Kuliner Nusantara</a>
            <div class="ms-auto">
                <span class="text-white me-3">Welcome, Admin!</span>
                <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="hero-title">Jelajahi Kekayaan Kuliner Indonesia</h1>
                    <p class="hero-subtitle">Dari Sabang sampai Merauke, temukan kelezatan otentik Nusantara</p>
                    <div class="hero-buttons mt-4">
                        <a href="#featured-recipes" class="btn-primary-custom">Lihat Resep</a>
                        <a href="#" class="btn-secondary-custom">Jelajahi Daerah</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori Daerah / Peta Kuliner -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">Jelajahi Berdasarkan Daerah</h2>
                <div>
                    <button class="btn btn-success btn-sm btn-crud"><i class="fas fa-plus"></i> Create</button>
                </div>
            </div>
            <div class="row">
                <!-- Daerah 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://i.pinimg.com/736x/f1/85/3d/f1853d27f6d8eef6dfba21e18534ff98.jpg" alt="Kuliner Sumatera">
                        <div class="region-info">
                            <h5>Sumatera</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/sumatera.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Daerah 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://i.pinimg.com/736x/65/99/d8/6599d8b5261f20d3f1863e94f6be9522.jpg" alt="Kuliner Jawa">
                        <div class="region-info">
                            <h5>Jawa</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/jawa.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Daerah 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://i.pinimg.com/736x/58/e3/58/58e358d94c863915b0221f50640ff761.jpg" alt="Kuliner Kalimantan">
                        <div class="region-info">
                            <h5>Kalimantan</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/kalimantan.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Daerah 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://i.pinimg.com/736x/70/6c/ae/706cae701324ca56a2c4c5929f990574.jpg" alt="Kuliner Sulawesi">
                        <div class="region-info">
                            <h5>Sulawesi</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/sulawesi.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Daerah 5 -->
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://pelita-air.com/admin/assets/uploads/images/promotion/2023-07/5-kuliner-halal-yang-wajib-dicoba-di-bali-9267.webp" alt="Kuliner Bali & Nusa Tenggara">
                        <div class="region-info">
                            <h5>Bali & Nusa Tenggara</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/bali-ntt-ntb.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Daerah 6 -->
                 <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://ik.imagekit.io/tvlk/blog/2021/01/Papeda-shutterstock_1719918754-1024x682.jpeg?tr=q-70,c-at_max,w-500,h-300,dpr-2" alt="Kuliner Maluku">
                        <div class="region-info">
                            <h5>Maluku</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/maluku.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Daerah 7 -->
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhJ6xx0RsKXuAqBCLBZqSQVnZFUt9GrsTwfqOCzkl8LqNEcuJwH0-KcLjabDT31e86XGtfiRwLvMy-A7PBA-UpUtEjizO_Hpt-PiGZduocJUU0X2iPCZ16_mlU7n6hMjca5_hyphenhyphenCZ8xWbhaD/s1600/IMG_papoeabynature3.jpg" alt="Kuliner Papua">
                        <div class="region-info">
                            <h5>Papua</h5>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/papua.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>  
                    </div>
                </div>
        </div>
    </section>

    <!-- Resep Unggulan -->
    <section class="py-5 bg-light" id="featured-recipes">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">Resep Populer</h2>
                <div>
                    <button class="btn btn-success btn-sm btn-crud"><i class="fas fa-plus"></i> Create</button>
                </div>
            </div>
            <div class="row">
                <!-- Recipe Card 1 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-utama">
                    <div class="recipe-card">
                        <img src="https://i.pinimg.com/736x/09/f9/b3/09f9b321b01b2f617b6a7eadb1e59c73.jpg" alt="Rendang">
                        <div class="recipe-info">
                            <h5>Rendang Padang</h5>
                            <p class="text-muted">Sumatera | 240 menit | Sulit</p>
                            <a href="pages/populer.html" class="btn btn-primary btn-sm mb-2">Lihat Resep</a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recipe Card 2 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-utama">
                    <div class="recipe-card">
                        <img src="https://i.pinimg.com/736x/f3/80/ce/f380ce84bab60653bba44fc2d44cf53f.jpg" alt="Soto Betawi">
                        <div class="recipe-info">
                            <h5>Soto Betawi</h5>
                            <p class="text-muted">Jawa | 120 menit | Sedang</p>
                            <a href="pages/populer.html" class="btn btn-primary btn-sm mb-2">Lihat Resep</a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recipe Card 3 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-ringan">
                    <div class="recipe-card">
                        <img src="https://i.pinimg.com/736x/90/23/46/902346b628613ba4d39882cc75500f4a.jpg" alt="Tempe Mendoan">
                        <div class="recipe-info">
                            <h5>Tempe Mendoan</h5>
                            <p class="text-muted">Jawa | 30 menit | Mudah</p>
                            <a href="pages/populer.html" class="btn btn-primary btn-sm mb-2">Lihat Resep</a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recipe Card 4 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="kue-tradisional">
                    <div class="recipe-card">
                        <img src="https://i.pinimg.com/736x/de/ef/f1/deeff16a19fdbec65b5d58bf8b494678.jpg" alt="Klappertaart">
                        <div class="recipe-info">
                            <h5>Klappertaart</h5>
                            <p class="text-muted">Sulawesi | 45 menit | Mudah</p>
                            <a href="pages/populer.html" class="btn btn-primary btn-sm mb-2">Lihat Resep</a>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recipe Card 5 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="minuman-tradisional">
                    <div class="recipe-card">
                        <img src="https://i.pinimg.com/736x/58/ad/aa/58adaaaea8e65c25cc25ce2a2042ef0d.jpg" alt="Es Cendol">
                        <div class="recipe-info">
                            <h5>Wedang Ronde</h5>
                            <p class="text-muted">Jawa | 20 menit | Mudah</p>
                            <a href="pages/populer.html" class="btn btn-primary btn-sm mb-2">Lihat Resep</a> 
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recipe Card 6 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-utama">
                    <div class="recipe-card">
                        <img src="https://i.pinimg.com/736x/7b/d4/7e/7bd47ea0ce92314b5e61681e6c62baa5.jpg" alt="Ayam Betutu">
                        <div class="recipe-info">
                            <h5>Ayam Betutu</h5>
                            <p class="text-muted ">Bali | 60 menit | Sedang</p>
                            <a href="pages/populer.html" class="btn btn-primary btn-sm mb-2">Lihat Resep</a> 
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- dst... Tambahkan resep lain sesuai kebutuhan -->
            </div>
        </div>
    </section>

    <!-- Kategori Makanan -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">Kategori Makanan</h2>
                <div>
                    <button class="btn btn-success btn-sm btn-crud"><i class="fas fa-plus"></i> Create</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="region-card">
                        <div class="region-info">
                            <h5>Makanan Utama</h5>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="region-card">
                        <div class="region-info">
                            <h5>Makanan Ringan</h5>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="region-card">
                        <div class="region-info">
                            <h5>Kue Tradisional</h5>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="region-card">
                        <div class="region-info">
                            <h5>Minuman Tradisional</h5>
                            <div class="btn-crud-group">
                                <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tambahkan di bawah section Kategori Makanan, sebelum Footer -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Kelola Tentang Kami</h2>
            <div>
                <button class="btn btn-success btn-sm btn-crud"><i class="fas fa-plus"></i> Create</button>
            </div>
        </div>
        <div class="card region-card mb-3">
            <div class="card-body">
                <h5 class="card-title">Visi & Misi</h5>
                <p class="card-text">Menjadi platform kuliner Nusantara terdepan yang menginspirasi dan memperkenalkan kekayaan rasa Indonesia ke seluruh dunia.</p>
                <div class="btn-crud-group">
                    <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card region-card mb-3">
            <div class="card-body">
                <h5 class="card-title">Tim Kami</h5>
                <ul>
                    <li>Dhonan - CEO</li>
                    <li>Rinakit & Linda - CTO</li>
                    <li>Ucel & Maura - Marketing</li>
                    <li>Irza & Salmaa - Customer Service</li>
                </ul>
                <div class="btn-crud-group">
                    <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card region-card mb-3">
            <div class="card-body">
                <h5 class="card-title">Kontak</h5>
                <ul>
                    <li>Alamat: UMY, Yogyakarta</li>
                    <li>Telepon: (+62)0123456789</li>
                    <li>Email: pdwgroup3@mail.com</li>
                    <li>Jam Operasional: Senin - Jumat, 08.00 - 17.00 WIB</li>
                    <li>Instagram: @group3keren</li>
                </ul>
                <div class="btn-crud-group">
                    <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Tambahkan di bawah section Kelola Tentang Kami -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="section-title mb-0">Kelola Profil Admin</h2>
            <div>
                <button class="btn btn-success btn-sm btn-crud"><i class="fas fa-plus"></i> Create</button>
            </div>
        </div>
        <div class="card region-card mb-3">
            <div class="card-body">
                <h5 class="card-title">Profil Admin</h5>
                <ul>
                    <li>Nama: Admin Utama</li>
                    <li>Username: admin</li>
                    <li>Email: admin@kulinernusantara.id</li>
                    <li>No. HP: 0812-3456-7890</li>
                </ul>
                <div class="btn-crud-group">
                    <button class="btn btn-warning btn-sm btn-crud"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm btn-crud"><i class="fas fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Footer -->
    <footer class="footer text-center py-4 bg-light">
        <div class="container">
            <span class="text-muted">&copy; 2025 Kuliner Nusantara - Admin Dashboard</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>