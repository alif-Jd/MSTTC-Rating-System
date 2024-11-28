<?php
header('Content-Type: application/json'); // Set header to JSON

include 'config.php'; // Include your database connection configuration

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute SQL query to count playstyles
    $stmt = $pdo->prepare("SELECT Playstyle, COUNT(*) as count FROM player GROUP BY Playstyle");
    $stmt->execute();
    
    // Fetch results as associative array
    $playstyleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data as JSON
    echo json_encode($playstyleData);
} catch (PDOException $e) {
    // Output error message as JSON if there's an issue
    echo json_encode(["error" => $e->getMessage()]);
}

// Close the database connection
$pdo = null;
?>
