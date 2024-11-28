<?php
session_start();

// Check if the username and password were verified
if (!isset($_SESSION['username_verified']) || $_SESSION['username_verified'] !== true) {
    header("Location: AdminLogin.php"); // Redirect to login page if not verified
    exit();
}
?>
