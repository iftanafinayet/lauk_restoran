<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/auth.php';

requireAdminAuth();

$success_message = '';
$error_message = '';
$name = $description = $price = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    
    // Debug: Lihat data yang dikirim
    error_log("Add Menu Form Submitted:");
    error_log("Name: " . $name);
    error_log("Description: " . $description);
    error_log("Price: " . $price);
    
    if(!empty($name) && !empty($description) && !empty($price)) {
        // Handle file upload
        $image = null;
        $image_error = '';
        
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Check file size (max 2MB)
            if($_FILES['image']['size'] > 2097152) {
                $image_error = 'Ukuran file terlalu besar. Maksimal 2MB.';
            } else {
                // Check file type
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                $file_type = $_FILES['image']['type'];
                
                if(in_array($file_type, $allowed_types)) {
                    $image = file_get_contents($_FILES['image']['tmp_name']);
                } else {
                    $image_error = 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.';
                }
            }
        }
        
        if(empty($image_error)) {
            try {
                // Convert price to proper decimal format
                $price = floatval(str_replace(',', '.', $price));
                
                $stmt = $pdo->prepare("INSERT INTO menus (name, description, price, image) VALUES (?, ?, ?, ?)");
                $result = $stmt->execute([$name, $description, $price, $image]);
                
                if($result) {
                    $success_message = 'Menu berhasil ditambahkan!';
                    // Reset form
                    $name = $description = $price = '';
                } else {
                    $error_message = 'Gagal menambahkan menu. Silakan coba lagi.';
                }
                
            } catch(PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                $error_message = 'Terjadi kesalahan database: ' . $e->getMessage();
            }
        } else {
            $error_message = $image_error;
        }
    } else {
        $error_message = 'Harap lengkapi semua field yang wajib diisi.';
    }
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Tambah Menu Baru</h1>
            <p class="text-muted">Tambahkan menu baru ke restoran</p>
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Tambah Menu</h5>
                </div>
                <div class="card-body">
                    <?php if($success_message): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i><?= $success_message ?>
                            <div class="mt-2">
                                <a href="dashboard.php" class="btn btn-sm btn-success me-2">
                                    <i class="bi bi-list me-1"></i>Lihat Dashboard
                                </a>
                                <a href="add_menu.php" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah Menu Lain
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($error_message): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i><?= $error_message ?>
                        </div>
                    <?php endif; ?>

                    <!-- Debug Info (Hanya tampil jika ada error) -->
                    <?php if(isset($_POST) && !empty($_POST) && $error_message): ?>
                        <div class="alert alert-warning">
                            <h6>Debug Information:</h6>
                            <pre><?php print_r($_POST); ?></pre>
                            <?php if(isset($_FILES['image'])): ?>
                                <h6>File Info:</h6>
                                <pre><?php print_r($_FILES['image']); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nama Menu <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= htmlspecialchars($name) ?>" 
                                   required maxlength="255"
                                   placeholder="Contoh: Nasi Goreng Spesial">
                            <div class="form-text">Masukkan nama menu yang jelas dan deskriptif.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" required maxlength="1000"
                                      placeholder="Deskripsikan menu dengan detail..."><?= htmlspecialchars($description) ?></textarea>
                            <div class="form-text">Jelaskan bahan-bahan dan keunikan menu.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">
                                Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="<?= htmlspecialchars($price) ?>" 
                                       min="0" step="100" required
                                       placeholder="25000">
                            </div>
                            <div class="form-text">Masukkan harga dalam Rupiah.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Gambar Menu</label>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/jpeg, image/jpg, image/png, image/gif">
                            <div class="form-text">
                                Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                                Gambar bersifat opsional.
                            </div>
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="dashboard.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                            </div>
                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Menu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Info Panel -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Tips Menambah Menu
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li><small class="text-muted">✓ Gunakan nama menu yang menarik dan mudah diingat</small></li>
                        <li><small class="text-muted">✓ Deskripsi yang detail membantu pelanggan memahami menu</small></li>
                        <li><small class="text-muted">✓ Harga yang realistis dan kompetitif</small></li>
                        <li><small class="text-muted">✓ Gambar yang jelas meningkatkan daya tarik menu</small></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="border rounded p-2 bg-light">
                    <p class="mb-2"><strong>Preview Gambar:</strong></p>
                    <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">
                    <div class="mt-1">
                        <small class="text-muted">Nama: ${file.name}</small><br>
                        <small class="text-muted">Ukuran: ${(file.size / 1024).toFixed(2)} KB</small>
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const price = document.getElementById('price').value.trim();
    
    if (!name || !description || !price) {
        e.preventDefault();
        alert('Harap lengkapi semua field yang wajib diisi!');
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menambahkan...';
    submitBtn.disabled = true;
});
</script>

<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.form-label {
    font-weight: 600;
    color: #5a5c69;
}

.alert {
    border: none;
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #1cc88a;
}

.alert-danger {
    border-left-color: #e74a3b;
}

.alert-warning {
    border-left-color: #f6c23e;
}

.btn {
    border-radius: 0.35rem;
    font-weight: 600;
}
</style>

<?php include '../includes/footer.php'; ?>