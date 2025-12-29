<?php
include 'includes/db.php';

// Hanya dijalankan sekali untuk membuat admin pertama
$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

try {
    // Cek apakah admin sudah ada
    $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
    $count = $stmt->fetchColumn();
    
    if($count == 0) {
        $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        if($stmt->execute([$username, $password])) {
            echo "<div style='padding: 20px; background: #d4edda; color: #155724; border-radius: 5px;'>
                    <h3>Admin berhasil dibuat!</h3>
                    <p><strong>Username:</strong> admin</p>
                    <p><strong>Password:</strong> admin123</p>
                    <p><strong>⚠️ Hapus file ini setelah digunakan untuk keamanan!</strong></p>
                  </div>";
        }
    } else {
        echo "<div style='padding: 20px; background: #f8d7da; color: #721c24; border-radius: 5px;'>
                <h3>Admin sudah ada!</h3>
                <p>Hapus file ini untuk keamanan.</p>
              </div>";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>