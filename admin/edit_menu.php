<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/auth.php';

requireAdminAuth();

// Ambil data menu berdasarkan ID
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$menu) {
    header('Location: dashboard.php');
    exit;
}

$success_message = '';
$error_message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';
    
    if(!empty($name) && !empty($description) && !empty($price)) {
        try {
            // Jika ada file gambar baru
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
                $stmt = $pdo->prepare("UPDATE menus SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
                $stmt->execute([$name, $description, $price, $image, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE menus SET name = ?, description = ?, price = ? WHERE id = ?");
                $stmt->execute([$name, $description, $price, $id]);
            }
            
            $success_message = 'Menu berhasil diperbarui.';
            
            // Ambil data terbaru
            $stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
            $stmt->execute([$id]);
            $menu = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    } else {
        $error_message = 'Harap lengkapi semua field.';
    }
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Menu</h1>
            <p class="text-muted">Edit informasi menu</p>
        </div>
        <a href="dashboard.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <?php if($success_message): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($error_message): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i><?= $error_message ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Menu *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($menu['name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi *</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($menu['description']) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga *</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?= $menu['price'] ?>" min="0" step="0.01" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Menu (Opsional)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <?php if(!empty($menu['image'])): ?>
                                <div class="mt-2">
                                    <p>Gambar saat ini:</p>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($menu['image']) ?>" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php else: ?>
                                <div class="mt-2">
                                    <p class="text-muted">Tidak ada gambar</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Perbarui Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
