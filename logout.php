<?php
session_start();

$_SESSION['logout_message'] = 'Anda telah berhasil logout.';

session_destroy();

header('Location: login.php');
exit;
?>