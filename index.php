<?php
// Pengaturan koneksi database
$host = 'localhost';
$user = 'root';
$pass = ''; // Password default di XAMPP
$dbname = 'kuliner_nusantara';

$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memulai sesi PHP
session_start();

// Jika user belum login, arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner Nusantara - Kekayaan Masakan Tradisional Indonesia</title>
    <meta name="description" content="Jelajahi resep masakan tradisional Indonesia dari berbagai daerah. Temukan kekayaan kuliner nusantara dari Sabang sampai Merauke.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #d4821a;
            --secondary-color: #8b4513;
            --accent-color: #ff6b35;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--bg-light);
        }
        
        .playfair {
            font-family: 'Playfair Display', serif;
        }
        
        /* Header Styles */
        .header-top {
            background: var(--text-dark);
            color: white;
            padding: 8px 0;
            font-size: 0.9rem;
        }
        
        .main-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .logo h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        .logo span {
            color: var(--secondary-color);
        }
        
        .search-container {
            position: relative;
            max-width: 400px;
        }
        
        .search-container input {
            border-radius: 25px;
            border: 2px solid var(--primary-color);
            padding: 0.5rem 3rem 0.5rem 1rem;
        }
        
        .search-container button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            color: white;
        }
        
        .navbar-custom {
            background: var(--primary-color);
            padding: 0.8rem 0;
        }
        
        .navbar-custom .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .navbar-nav .nav-link:hover,
        .navbar-custom .navbar-nav .nav-link.active {
            background: rgba(255,255,255,0.1);
            border-radius: 5px;
        }
        
        /* Hero Section */
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
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
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
        
        /* Section Styles */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--text-dark);
        }
        
        /* Region Cards */
        .region-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }
        
        .region-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .region-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .region-info {
            padding: 1.5rem;
        }
        
        .region-info h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }
        
        .region-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .region-link:hover {
            color: var(--secondary-color);
        }
        
        /* Recipe Cards */
        .recipe-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            height: 100%;
        }
        
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .recipe-img {
            position: relative;
            overflow: hidden;
        }
        
        .recipe-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .recipe-card:hover .recipe-img img {
            transform: scale(1.05);
        }
        
        .recipe-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary-color);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .recipe-info {
            padding: 1.5rem;
        }
        
        .recipe-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: var(--text-dark);
        }
        
        .recipe-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: var(--text-light);
        }
        
        .recipe-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .recipe-desc {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .btn-recipe {
            background: var(--primary-color);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-recipe:hover {
            background: var(--secondary-color);
            color: white;
        }
        
        /* Filter Buttons */
        .filter-buttons {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .filter-btn {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            margin: 0.3rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
        }
        
        /* Story Cards */
        .story-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }
        
        .story-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .story-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .story-content {
            padding: 1.5rem;
        }
        
        .story-category {
            background: var(--accent-color);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .story-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin: 1rem 0;
            color: var(--text-dark);
        }
        
        .story-excerpt {
            color: var(--text-light);
            margin-bottom: 1rem;
        }
        
        .story-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        /* Newsletter */
        .newsletter {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4rem 0;
        }
        
        .newsletter h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .newsletter-form {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .newsletter-form .input-group input {
            border: none;
            border-radius: 25px 0 0 25px;
            padding: 0.8rem 1rem;
        }
        
        .newsletter-form .btn {
            border-radius: 0 25px 25px 0;
            background: var(--accent-color);
            border: none;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
        }
        
        /* Footer */
        .footer {
            background: var(--text-dark);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .footer ul {
            list-style: none;
            padding: 0;
        }
        
        .footer ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer ul li a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer ul li a:hover {
            color: var(--primary-color);
        }
        
        .social-links a {
            color: #bdc3c7;
            font-size: 1.5rem;
            margin-right: 1rem;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: var(--primary-color);
        }
        
        .footer-bottom {
            border-top: 1px solid #34495e;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #bdc3c7;
        }
        
        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: none;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .back-to-top:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <!-- Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="d-flex align-items-center w-100" style="padding: 10px 0;">
                    <div>
                        <!-- Dropdown Bahasa Indonesia -->
                        <select class="form-select">
                            <option>Bahasa Indonesia</option>
                        </select>
                    </div>
                    <div class="user-menu ms-auto">
                        <span>Welcome, <?php echo $_SESSION['username']; ?>!</span>
                        <a href="logout.php" class="user-menu-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <div class="main-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="logo">
                            <a href="index.html" class="text-decoration-none">
                                <h1 class="mb-0">Kuliner<span>Nusantara</span></h1>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.html">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Peta Kuliner
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="pages/daerah/sumatera.html">Sumatera</a></li>
                                <li><a class="dropdown-item" href="pages/daerah/jawa.html">Jawa</a></li>
                                <li><a class="dropdown-item" href="pages/daerah/kalimantan.html">Kalimantan</a></li>
                                <li><a class="dropdown-item" href="pages/daerah/sulawesi.html">Sulawesi</a></li>
                                <li><a class="dropdown-item" href="pages/daerah/bali-ntt-ntb.html">Bali & Nusa Tenggara</a></li>
                                <li><a class="dropdown-item" href="pages/daerah/maluku.html">Maluku</a></li>
                                <li><a class="dropdown-item" href="pages/daerah/papua.html">Papua</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/kategori.html">Kategori Makanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/populer.html">Resep Populer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/tentang.html">Tentang Kami</a>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="hero-title">Jelajahi Kekayaan Kuliner Indonesia</h1>
                    <p class="hero-subtitle">Dari Sabang sampai Merauke, temukan kelezatan otentik Nusantara</p>
                    <div class="hero-buttons mt-4">
                        <a href="#featured-recipes" class="btn-primary-custom">Lihat Resep</a>
                        <a href="pages/daerah.html" class="btn-secondary-custom">Jelajahi Daerah</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Kategori Daerah -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Jelajahi Berdasarkan Daerah</h2>
            
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <div class="region-img">
                            <img src="https://i.pinimg.com/736x/f1/85/3d/f1853d27f6d8eef6dfba21e18534ff98.jpg" alt="Kuliner Sumatera">
                        </div>
                        <div class="region-info">
                            <h3>Sumatera</h3>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/sumatera.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <div class="region-img">
                            <img src="https://i.pinimg.com/736x/65/99/d8/6599d8b5261f20d3f1863e94f6be9522.jpg" alt="Kuliner Jawa">
                        </div>
                        <div class="region-info">
                            <h3>Jawa</h3>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/jawa.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <div class="region-img">
                            <img src="https://i.pinimg.com/736x/58/e3/58/58e358d94c863915b0221f50640ff761.jpg" alt="Kuliner Kalimantan">
                        </div>
                        <div class="region-info">
                            <h3>Kalimantan</h3>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/kalimantan.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="region-card">
                        <div class="region-img">
                            <img src="https://i.pinimg.com/736x/70/6c/ae/706cae701324ca56a2c4c5929f990574.jpg" alt="Kuliner Sulawesi">
                        </div>
                        <div class="region-info">
                            <h3>Sulawesi</h3>
                            <p class="text-muted">3 Resep</p>
                            <a href="pages/daerah/sulawesi.html" class="region-link">Jelajahi <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="pages/daerah.html" class="btn btn-outline-primary btn-lg">Lihat Semua Daerah</a>
            </div>
        </div>
    </section>
    
    <!-- Resep Unggulan -->
    <section class="py-5 bg-light" id="featured-recipes">
        <div class="container">
            <h2 class="section-title">Resep Populer</h2>
            
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="makanan-utama">Makanan Utama</button>
                <button class="filter-btn" data-filter="makanan-ringan">Makanan Ringan</button>
                <button class="filter-btn" data-filter="kue-tradisional">Kue Tradisional</button>
                <button class="filter-btn" data-filter="minuman">Minuman</button>
            </div>
            
            <div class="row">
                <!-- Recipe Card 1 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-utama">
                    <div class="recipe-card">
                        <div class="recipe-img">
                            <img src="https://i.pinimg.com/736x/09/f9/b3/09f9b321b01b2f617b6a7eadb1e59c73.jpg" alt="Rendang">
                            <div class="recipe-badge">Sumatera</div>
                        </div>
                        <div class="recipe-info">
                            <h3 class="recipe-title">Rendang Padang</h3>
                            <div class="recipe-meta">
                                <span><i class="fas fa-clock"></i> 240 menit</span>
                                <span><i class="fas fa-signal"></i> Sulit</span>
                                <span><i class="fas fa-star"></i> 4.9</span>
                            </div>
                            <p class="recipe-desc">Hidangan daging sapi yang dimasak dengan rempah kaya dan santan hingga kering dan berwarna hitam kecoklatan.</p>
                            <a href="pages/populer.html" class="btn-recipe">Lihat Resep</a>
                        </div>
                    </div>
                </div>
                
                <!-- Recipe Card 2 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-utama">
                    <div class="recipe-card">
                        <div class="recipe-img">
                            <img src="https://i.pinimg.com/736x/f3/80/ce/f380ce84bab60653bba44fc2d44cf53f.jpg" alt="Soto Betawi">
                            <div class="recipe-badge">Jawa</div>
                        </div>
                        <div class="recipe-info">
                            <h3 class="recipe-title">Soto Betawi</h3>
                            <div class="recipe-meta">
                                <span><i class="fas fa-clock"></i> 120 menit</span>
                                <span><i class="fas fa-signal"></i> Sedang</span>
                                <span><i class="fas fa-star"></i> 4.7</span>
                            </div>
                            <p class="recipe-desc">Soto khas Jakarta dengan kuah santan yang gurih, berisi daging sapi, jeroan, dan pelengkap khas.</p>
                            <a href="pages/populer.html" class="btn-recipe">Lihat Resep</a>
                        </div>
                    </div>
                </div>
                
                <!-- Recipe Card 3 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-ringan">
                    <div class="recipe-card">
                        <div class="recipe-img">
                            <img src="https://i.pinimg.com/736x/90/23/46/902346b628613ba4d39882cc75500f4a.jpg" alt="Tempe Mendoan">
                            <div class="recipe-badge">Jawa</div>
                        </div>
                        <div class="recipe-info">
                            <h3 class="recipe-title">Tempe Mendoan</h3>
                            <div class="recipe-meta">
                                <span><i class="fas fa-clock"></i> 30 menit</span>
                                <span><i class="fas fa-signal"></i> Mudah</span>
                                <span><i class="fas fa-star"></i> 4.6</span>
                            </div>
                            <p class="recipe-desc">Tempe yang diiris tipis dan dibalut adonan tepung berbumbu, kemudian digoreng setengah matang.</p>
                            <a href="pages/populer.html" class="btn-recipe">Lihat Resep</a>
                        </div>
                    </div>
                </div>
                
                <!-- Recipe Card 4 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="kue-tradisional">
                    <div class="recipe-card">
                        <div class="recipe-img">
                            <img src="https://i.pinimg.com/736x/de/ef/f1/deeff16a19fdbec65b5d58bf8b494678.jpg" alt="Klappertaart">
                            <div class="recipe-badge">Sulawesi</div>
                        </div>
                        <div class="recipe-info">
                            <h3 class="recipe-title">Klappertaart</h3>
                            <div class="recipe-meta">
                                <span><i class="fas fa-clock"></i> 60 menit</span>
                                <span><i class="fas fa-signal"></i> Sedang</span>
                                <span><i class="fas fa-star"></i> 4.8</span>
                            </div>
                            <p class="recipe-desc">Klappertart adalah kue khas Manado dari kelapa parut, susu, dan telur, dipanggang hingga lembut dengan rasa manis dan kelapa.</p>
                            <a href="pages/populer.html" class="btn-recipe">Lihat Resep</a>
                        </div>
                    </div>
                </div>
                
                <!-- Recipe Card 5 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="minuman">
                    <div class="recipe-card">
                        <div class="recipe-img">
                            <img src="https://i.pinimg.com/736x/58/ad/aa/58adaaaea8e65c25cc25ce2a2042ef0d.jpg" alt="Wedang Ronde">
                            <div class="recipe-badge">Jawa</div>
                        </div>
                        <div class="recipe-info">
                            <h3 class="recipe-title">Wedang Ronde</h3>
                            <div class="recipe-meta">
                                <span><i class="fas fa-clock"></i> 45 menit</span>
                                <span><i class="fas fa-signal"></i> Sedang</span>
                                <span><i class="fas fa-star"></i> 4.5</span>
                            </div>
                            <p class="recipe-desc">Minuman hangat dengan bola-bola tepung ketan berisi kacang, disajikan dengan kuah jahe dan gula merah.</p>
                            <a href="pages/populer.html" class="btn-recipe">Lihat Resep</a>
                        </div>
                    </div>
                </div>
                
                <!-- Recipe Card 6 -->
                <div class="col-lg-4 col-md-6 mb-4" data-category="makanan-utama">
                    <div class="recipe-card">
                        <div class="recipe-img">
                            <img src="https://i.pinimg.com/736x/7b/d4/7e/7bd47ea0ce92314b5e61681e6c62baa5.jpg" alt="Ayam Betutu">
                            <div class="recipe-badge">Bali</div>
                        </div>
                        <div class="recipe-info">
                            <h3 class="recipe-title">Ayam Betutu</h3>
                            <div class="recipe-meta">
                                <span><i class="fas fa-clock"></i> 180 menit</span>
                                <span><i class="fas fa-signal"></i> Sulit</span>
                                <span><i class="fas fa-star"></i> 4.7</span>
                            </div>
                            <p class="recipe-desc">Ayam utuh yang diisi bumbu rempah khas Bali, kemudian dipanggang dalam bungkusan daun pisang.</p>
                            <a href="pages/populer.html" class="btn-recipe">Lihat Resep</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="pages/kategori.html" class="btn btn-primary btn-lg">Lihat Semua Resep</a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h3>Tentang Kuliner Nusantara</h3>
                    <p>Kuliner Nusantara adalah platform yang didedikasikan untuk melestarikan dan mempromosikan kekayaan masakan tradisional Indonesia dari berbagai daerah.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h3>Link Cepat</h3>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pages/populer.html">Resep Populer</a></li>
                        <li><a href="pages/daerah.html">Peta Kuliner</a></li>
                        <li><a href="pages/tentang.html">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3>Kategori Makanan</h3>
                    <ul>
                        <li><a href="pages/kategori.html">Makanan Utama</a></li>
                        <li><a href="pages/kategori.html">Makanan Ringan</a></li>
                        <li><a href="pages/kategori.html">Kue Tradisional</a></li>
                        <li><a href="pages/kategori.html">Minuman Tradisional</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3>Hubungi Kami</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> UMY, Yogyakarta</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (+62)0123456789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> pdwgroup3@mail.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Kuliner Nusantara. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top"><i class="fas fa-arrow-up"></i></button>
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script >
        // Recipe Filter
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const recipeCards = document.querySelectorAll('[data-category]');
            
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    recipeCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
            
            // Search functionality
            const searchForm = document.getElementById('search-form');
            const searchInput = document.getElementById('search-input');
            
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.toLowerCase();
                // Add your search logic here
                console.log('Searching for:', searchTerm);
            });
            
            // Newsletter form
            const newsletterForm = document.getElementById('newsletter-form');
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Terima kasih telah berlangganan newsletter kami!');
            });
            
            // Back to top button
            const backToTopBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopBtn.style.display = 'block';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });
            
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>