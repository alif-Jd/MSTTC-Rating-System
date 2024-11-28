<?php
header('Content-Type: application/json'); // Set header to JSON

include 'config.php'; // Include your database connection configuration

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count Grip types
    $stmt = $pdo->prepare("SELECT Grip, COUNT(*) as count FROM player GROUP BY Grip");
    $stmt->execute();
    
    // Fetch results as associative array
    $gripData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data as JSON
    echo json_encode($gripData);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

$pdo = null;
?>
