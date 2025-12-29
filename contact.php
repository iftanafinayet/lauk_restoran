<?php
include 'includes/header.php';
include 'includes/db.php';

$success_message = '';
$error_message = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if(!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Simpan pesan ke database (opsional)
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            $success_message = 'Pesan Anda telah berhasil dikirim. Kami akan membalasnya segera.';
        } catch(PDOException $e) {
            $error_message = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    } else {
        $error_message = 'Harap lengkapi semua field.';
    }
}

// Buat tabel contact_messages jika belum ada
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch(PDOException $e) {
    // Table creation failed, but we can continue
}
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-white mb-3">Hubungi Kami</h1>
                <p class="lead text-white">Kami siap melayani Anda dengan yang terbaik</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
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
                
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Kirim Pesan</h3>
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek *</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan *</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="row mt-5">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <i class="bi bi-geo-alt-fill text-primary display-4 mb-3"></i>
                        <h5>Alamat</h5>
                        <p class="text-muted">Jl. Restoran No. 123<br>Jakarta Pusat, 10110</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <i class="bi bi-telephone-fill text-primary display-4 mb-3"></i>
                        <h5>Telepon</h5>
                        <p class="text-muted">(021) 1234-5678<br>+62 812-3456-7890</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <i class="bi bi-envelope-fill text-primary display-4 mb-3"></i>
                        <h5>Email</h5>
                        <p class="text-muted">info@laukresto.com<br>order@laukresto.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>