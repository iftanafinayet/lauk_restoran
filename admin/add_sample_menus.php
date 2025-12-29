<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/auth.php';

requireAdminAuth();

$success_message = '';
$error_message = '';

// Data dummy menu
$sample_menus = [
    [
        'name' => 'Nasi Goreng Spesial',
        'description' => 'Nasi goreng dengan campuran ayam suwir, udang, telur, dan sayuran segar, dilengkapi dengan kerupuk dan acar',
        'price' => 25000.00
    ],
    [
        'name' => 'Ayam Bakar Madu',
        'description' => 'Ayam pilihan dibakar dengan bumbu madu spesial, disajikan dengan sambal terasi dan lalapan segar',
        'price' => 35000.00
    ],
    [
        'name' => 'Gurame Asam Manis',
        'description' => 'Ikan gurame segar digoreng krispi lalu disiram saus asam manis dengan nanas dan paprika',
        'price' => 45000.00
    ],
    [
        'name' => 'Gado-gado Jakarta',
        'description' => 'Salad tradisional Indonesia dengan sayuran segar, telur, tahu, tempe, dan kerupuk, disiram bumbu kacang spesial',
        'price' => 22000.00
    ],
    [
        'name' => 'Sate Ayam Madura',
        'description' => 'Tusukan daging ayam bakar dengan bumbu kacang khas Madura, disajikan dengan lontong dan bawang goreng',
        'price' => 30000.00
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_samples'])) {
    try {
        $pdo->beginTransaction();
        
        $added_count = 0;
        foreach ($sample_menus as $menu) {
            // Cek apakah menu sudah ada
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM menus WHERE name = ?");
            $stmt->execute([$menu['name']]);
            $exists = $stmt->fetchColumn();
            
            if (!$exists) {
                $stmt = $pdo->prepare("INSERT INTO menus (name, description, price) VALUES (?, ?, ?)");
                $stmt->execute([$menu['name'], $menu['description'], $menu['price']]);
                $added_count++;
            }
        }
        
        $pdo->commit();
        $success_message = "Berhasil menambahkan $added_count menu sample!";
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error_message = "Terjadi kesalahan: " . $e->getMessage();
    }
}

// Hitung total menu saat ini
$stmt = $pdo->query("SELECT COUNT(*) as total FROM menus");
$total_menus = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Menu Sample</h1>
            <p class="text-muted">Tambahkan data dummy menu untuk pengembangan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="../index.php" class="btn btn-outline-primary">
                <i class="bi bi-house me-2"></i>Ke Beranda
            </a>
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><?= $total_menus ?></h2>
                        <p class="mb-0">Total Menu Saat Ini</p>
                    </div>
                    <i class="bi bi-menu-button" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Menu Sample yang Akan Ditambahkan</h5>
                </div>
                <div class="card-body">
                    <?php if($success_message): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
                            <br><small>Anda akan diarahkan ke dashboard dalam 3 detik...</small>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = 'dashboard.php';
                            }, 3000);
                        </script>
                    <?php endif; ?>
                    
                    <?php if($error_message): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i><?= $error_message ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Menu</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($sample_menus as $menu): 
                                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM menus WHERE name = ?");
                                    $stmt->execute([$menu['name']]);
                                    $exists = $stmt->fetchColumn();
                                ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($menu['name']) ?></strong></td>
                                        <td class="text-muted" style="max-width: 300px;"><?= htmlspecialchars($menu['description']) ?></td>
                                        <td>Rp <?= number_format($menu['price'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if($exists): ?>
                                                <span class="badge bg-success">Sudah Ada</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Akan Ditambahkan</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <form method="POST" class="mt-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Menu yang sudah ada di database tidak akan ditambahkan kembali.
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" name="add_samples" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Tambahkan Menu Sample
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stats-card h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
</style>

<?php include '../includes/footer.php'; ?>
