<?php
include 'includes/header.php';
include 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM menus ORDER BY created_at DESC LIMIT 6");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold">Nikmati Kelezatan <span class="text-gradient">Autentik</span></h1>
                    <p class="lead">Setiap hidangan di Lauk Resto dibuat dengan bahan-bahan pilihan dan resep turun-temurun untuk memberikan pengalaman kuliner terbaik.</p>
                    <div class="hero-buttons">
                        <a href="menu.php" class="btn btn-primary btn-lg me-3">
                            <i class="bi bi-menu-button me-2"></i>Lihat Menu
                        </a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-telephone me-2"></i>Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <div class="placeholder-image bg-light rounded-custom d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-egg-fried display-1"></i>
                            <p class="mt-2">Hero Image</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h4>Kualitas Premium</h4>
                    <p class="text-muted">Bahan-bahan segar dan berkualitas tinggi dipilih langsung untuk memastikan cita rasa terbaik.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <h4>Pelayanan Cepat</h4>
                    <p class="text-muted">Proses pemesanan dan penyajian yang efisien tanpa mengorbankan kualitas hidangan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <h4>Harga Terjangkau</h4>
                    <p class="text-muted">Menu lezat dengan harga yang kompetitif, cocok untuk semua kalangan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Populer Section -->
<section class="menu-section">
    <div class="container">
        <div class="section-header">
            <h2>Menu Populer</h2>
            <p class="text-muted">Pilihan favorit pelanggan kami</p>
        </div>
        
        <div class="row g-4">
            <?php if(count($menus) > 0): ?>
                <?php foreach($menus as $menu): ?>
                    <div class="col-xl-4 col-md-6">
                        <div class="card menu-card h-100">
                            <div class="card-img-container">
                                <?php if(!empty($menu['image'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($menu['image']) ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($menu['name']) ?>">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-overlay">
                                    <span class="badge bg-primary">Rp <?= number_format($menu['price'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($menu['name']) ?></h5>
                                <p class="card-text text-muted flex-grow-1"><?= htmlspecialchars($menu['description']) ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">Rp <?= number_format($menu['price'], 0, ',', '.') ?></span>
                                    <button class="btn btn-outline-primary btn-sm" onclick="orderMenu(<?= $menu['id'] ?>, '<?= htmlspecialchars($menu['name']) ?>')">
                                        <i class="bi bi-cart-plus me-1"></i>Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-emoji-frown display-1 text-muted"></i>
                        <h4 class="mt-3 text-muted">Belum ada menu tersedia</h4>
                        <p class="text-muted">Silakan kembali nanti untuk melihat menu kami.</p>
                        <?php if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                            <a href="admin/dashboard.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Menu
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if(count($menus) > 0): ?>
            <div class="text-center mt-5">
                <a href="menu.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-right me-2"></i>Lihat Semua Menu
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>