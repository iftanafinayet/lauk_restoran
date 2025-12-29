<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/auth.php';

requireAdminAuth();

// Hitung jumlah menu
$stmt = $pdo->query("SELECT COUNT(*) as total_menus FROM menus");
$total_menus = $stmt->fetch(PDO::FETCH_ASSOC)['total_menus'];

// Ambil menu terbaru
$stmt = $pdo->query("SELECT * FROM menus ORDER BY created_at DESC LIMIT 5");
$recent_menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard Admin</h1>
            <p class="text-muted">Selamat datang, <?= $_SESSION['admin_username'] ?>!</p>
        </div>
        <div class="d-flex gap-2">
            <a href="../index.php" class="btn btn-outline-primary">
                <i class="bi bi-house me-2"></i>Kembali ke User
            </a>
            <a href="add_menu.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Menu
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= $total_menus ?></h2>
                        <p class="mb-0">Total Menu</p>
                    </div>
                    <i class="bi bi-menu-button" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= count($recent_menus) ?></h2>
                        <p class="mb-0">Menu Terbaru</p>
                    </div>
                    <i class="bi bi-clock-history" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2>Admin</h2>
                        <p class="mb-0"><?= $_SESSION['admin_username'] ?></p>
                    </div>
                    <i class="bi bi-person-circle" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2>Quick</h2>
                        <p class="mb-0">Actions</p>
                    </div>
                    <i class="bi bi-lightning" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="add_menu.php" class="btn btn-primary w-100 d-flex align-items-center justify-content-center p-3">
                                <div class="text-center">
                                    <i class="bi bi-plus-circle display-6 mb-2"></i>
                                    <div>Tambah Menu</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="../menu.php" class="btn btn-success w-100 d-flex align-items-center justify-content-center p-3">
                                <div class="text-center">
                                    <i class="bi bi-eye display-6 mb-2"></i>
                                    <div>Lihat Menu</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="../index.php" class="btn btn-info w-100 d-flex align-items-center justify-content-center p-3">
                                <div class="text-center">
                                    <i class="bi bi-house display-6 mb-2"></i>
                                    <div>Ke Beranda</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="../logout.php" class="btn btn-danger w-100 d-flex align-items-center justify-content-center p-3">
                                <div class="text-center">
                                    <i class="bi bi-box-arrow-right display-6 mb-2"></i>
                                    <div>Logout</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Menus -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Menu Terbaru</h5>
            <div class="d-flex gap-2">
                <a href="../menu.php" class="btn btn-sm btn-outline-primary">Lihat Semua Menu</a>
                <a href="add_sample_menus.php" class="btn btn-sm btn-outline-success">Tambah Sample</a>
            </div>
        </div>
        <div class="card-body">
            <?php if(count($recent_menus) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_menus as $menu): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($menu['name']) ?></strong>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= substr($menu['description'], 0, 50) ?>...</small>
                                    </td>
                                    <td>Rp <?= number_format($menu['price'], 0, ',', '.') ?></td>
                                    <td><?= date('d M Y', strtotime($menu['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="edit_menu.php?id=<?= $menu['id'] ?>" 
                                               class="btn btn-outline-warning" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete_menu.php?id=<?= $menu['id'] ?>" 
                                               class="btn btn-outline-danger" 
                                               title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Belum ada menu</h5>
                    <p class="text-muted">Mulai dengan menambahkan menu pertama Anda.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="add_menu.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Menu Pertama
                        </a>
                        <a href="add_sample_menus.php" class="btn btn-success">
                            <i class="bi bi-collection me-2"></i>Tambah Sample Menu
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.stats-card {
    color: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.stats-card h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.quick-action-btn {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.quick-action-btn:hover {
    transform: translateY(-3px);
}
</style>

<?php include '../includes/footer.php'; ?>
