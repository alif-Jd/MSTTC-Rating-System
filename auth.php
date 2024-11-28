<?php
session_start(); // Start session at the top of the page

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header("Location: AdminLogin.php");
    exit();
}

// Set the session timeout duration 
$timeout_duration = 1200; // 900 seconds = 15 minutes

if (isset($_SESSION['login_time'])) {
    if (time() - $_SESSION['login_time'] > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: AdminLogin.php?error=Session expired, please log in again.");
        exit();
    } else {
        // Update the login time to extend the session
        $_SESSION['login_time'] = time();
    }
}
?>
