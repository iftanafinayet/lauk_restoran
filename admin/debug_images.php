<?php
// debug_images.php - Untuk debugging gambar di database
include 'includes/header.php';
include 'includes/db.php';

// Cek apakah admin sudah login
if(!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT id, name, LENGTH(image) as image_size FROM menus");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h1>Debug Images</h1>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Menu</th>
                <th>Ukuran Gambar (bytes)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($menus as $menu): ?>
                <tr>
                    <td><?= $menu['id'] ?></td>
                    <td><?= htmlspecialchars($menu['name']) ?></td>
                    <td><?= $menu['image_size'] ?></td>
                    <td>
                        <?php if($menu['image_size'] > 0): ?>
                            <span class="badge bg-success">Ada Gambar</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Tidak Ada Gambar</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
