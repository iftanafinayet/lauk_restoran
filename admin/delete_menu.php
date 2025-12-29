<?php
include '../includes/header.php';
include '../includes/db.php';
include '../includes/auth.php';

requireAdminAuth();

// Hapus menu berdasarkan ID
$id = $_GET['id'] ?? 0;

if($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM menus WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['success_message'] = 'Menu berhasil dihapus.';
    } catch(PDOException $e) {
        $_SESSION['error_message'] = 'Terjadi kesalahan: ' . $e->getMessage();
    }
}

header('Location: dashboard.php');
exit;
?>