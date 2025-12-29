<?php
session_start();

// Determine base path
$base_path = '/lauk_restoran';
if (isset($_SERVER['CONTEXT_PREFIX'])) {
    $base_path = $_SERVER['CONTEXT_PREFIX'];
}

// Check if we're in admin directory
$is_admin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
$assets_path = $is_admin ? '../assets' : 'assets';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lauk Restoran - Makanan Enak & Berkualitas</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= $assets_path ?>/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= $is_admin ? '../index.php' : 'index.php' ?>">
                <i class="bi bi-egg-fried me-2"></i>
                LAUK RESTO <?= $is_admin ? '- ADMIN' : '' ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $is_admin ? '../index.php' : 'index.php' ?>">
                            <i class="bi bi-house me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $is_admin ? '../menu.php' : 'menu.php' ?>">
                            <i class="bi bi-menu-button me-1"></i>Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $is_admin ? '../about.php' : 'about.php' ?>">
                            <i class="bi bi-info-circle me-1"></i>Tentang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $is_admin ? '../contact.php' : 'contact.php' ?>">
                            <i class="bi bi-telephone me-1"></i>Kontak
                        </a>
                    </li>
                    
                    <?php if($is_admin && isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i><?= $_SESSION['admin_username'] ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if($is_admin): ?>
                                    <li>
                                        <a class="dropdown-item" href="dashboard.php">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="add_menu.php">
                                            <i class="bi bi-plus-circle me-2"></i>Tambah Menu
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php else: ?>
                                    <li>
                                        <a class="dropdown-item" href="admin/dashboard.php">
                                            <i class="bi bi-speedometer2 me-2"></i>Admin Panel
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="index.php">
                                        <i class="bi bi-house me-2"></i>Kembali ke User
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-lock me-1"></i>Admin
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="main-content">