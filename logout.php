<?php
session_start(); // Start session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to login page
header("Location: AdminLogin.php");
exit();
?>
