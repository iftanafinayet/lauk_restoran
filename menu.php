<?php
include 'includes/header.php';
include 'includes/db.php';

// Ambil semua menu dari database
$stmt = $pdo->query("SELECT * FROM menus ORDER BY created_at DESC");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_menus = count($menus);
?>

<!-- Hero Section untuk Menu -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-white mb-3">Menu Kami</h1>
                <p class="lead text-white mb-4">Jelajahi berbagai pilihan hidangan lezat yang dibuat dengan bahan-bahan berkualitas</p>
                <div class="menu-stats">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="bi bi-egg-fried me-1"></i>
                        <?= $total_menus ?> Menu Tersedia
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Grid Section -->
<section class="menu-section">
    <div class="container">
        <?php if($total_menus > 0): ?>
            <div class="row g-4">
                <?php foreach($menus as $menu): ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
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
                                    <button class="btn btn-primary btn-sm" onclick="orderMenu(<?= $menu['id'] ?>, '<?= htmlspecialchars($menu['name']) ?>')">
                                        <i class="bi bi-whatsapp me-1"></i>Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
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
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>