<?php
// Authentication helper functions
function requireAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        header('Location: ../login.php');
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