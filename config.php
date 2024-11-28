<?php
// Database configuration
$servername = "localhost"; // Use "localhost" for Hostinger; otherwise, check Hostinger's control panel for the specific hostname
$username = "u927582686_msttc_db"; // Your database username from Hostinger
$password = "msttc_dbConnect04"; // Your database password from Hostinger
$dbname = "u927582686_msttc_db"; // Your database name from Hostinger

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

?>
