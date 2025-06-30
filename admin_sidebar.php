<nav class="d-flex flex-column flex-shrink-0 p-3 sidebar-custom" style="width: 220px; min-height:100vh; position:fixed;"> <!-- Sidebar for admin navigation -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <a href="admin_dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <span class="fs-4 fw-bold" style="color:#d4841c;">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="admin_dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='admin_dashboard.php'?'active':''; ?>">
                Dashboard
            </a>
        </li>
        <li>
            <a href="admin_users.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='admin_users.php'?'active':''; ?>">
                User Management
            </a>
        </li>
        <li>
            <a href="admin_team.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='admin_team.php'?'active':''; ?>">
                Tim Kami
            </a>
        </li>
        <li>
            <a href="admin_pesan.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF'])=='admin_pesan.php'?'active':''; ?>">
                Pesan Masuk
            </a>
        </li>
    </ul>
    <hr>
    <div>
        <a href="logout.php" class="btn btn-outline-danger btn-sm w-100">Logout</a>
    </div>
</nav>
<style>
    .sidebar-custom {
        background: #fff7ec;
        font-family: 'Poppins', sans-serif;
        border-right: 2px solid #f3e7d7;
    }
    .sidebar-custom .nav-link {
        color: #d4841c;
        font-weight: 500;
        border-radius: 8px;
        margin-bottom: 4px;
        transition: background 0.2s, color 0.2s;
    }
    .sidebar-custom .nav-link.active,
    .sidebar-custom .nav-link:hover {
        background: #d4841c;
        color: #fff !important;
    }
</style>

<!-- kenapa buat admin_sidebar? biar bisa digunakan ulang di semua halaman admin, cuman include aja -->