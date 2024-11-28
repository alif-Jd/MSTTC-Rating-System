<?php
header('Content-Type: application/json'); // Set header to JSON

include 'config.php'; // Include your database connection configuration

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to count CareerType levels
    $stmt = $pdo->prepare("SELECT CareerType, COUNT(*) as count FROM player GROUP BY CareerType");
    $stmt->execute();
    
    // Fetch results as associative array
    $careerTypeData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data as JSON
    echo json_encode($careerTypeData);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

$pdo = null;
?>
