<?php
// Pastikan session_start() pertama kali dipanggil
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Authentication helper functions
function requireAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        // Redirect ke login dengan absolute path
        header('Location: /login.php');
        exit;
    }
}

function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];
}

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
