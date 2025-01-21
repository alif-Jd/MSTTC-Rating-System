<?php
// Database configuration
$servername = "localhost"; // Use "localhost" for Hostinger; otherwise, check Hostinger's control panel for the specific hostname
$username = ""; // Your database username from Hostinger
$password = ""; // Your database password from Hostinger
$dbname = ""; // Your database name from Hostinger

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

?>
