<?php
session_start();
include 'includes/db.php';

if(isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        
        // Redirect ke halaman sebelumnya atau dashboard
        if(isset($_GET['from']) && $_GET['from'] == 'modal') {
            header('Location: dashboard.php');
        } else {
            header('Location: dashboard.php');
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card login-card">
            <div class="card-header text-center">
                <h4>
                    <i class="fas fa-user-cog me-2"></i>Admin Panel
                </h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required 
                               placeholder="Masukkan username admin">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-key me-2"></i>Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Masukkan password">
                    </div>
                    <button type="submit" class="btn btn-modern w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="index.php" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Info Box -->
        <div class="card glass-effect mt-4">
            <div class="card-body">
                <h6><i class="fas fa-info-circle me-2"></i>Informasi Login</h6>
                <small class="text-muted">
                    Gunakan kredensial admin yang telah diberikan untuk mengakses panel administrasi.
                </small>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>