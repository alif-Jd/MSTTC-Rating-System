<?php
// Database configuration
$servername = "localhost"; // Use "localhost" 
$username = ""; // Your database username 
$password = ""; // Your database password 
$dbname = ""; // Your database name 

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

?>
