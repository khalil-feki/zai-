<?php
// Database connection test script
require_once 'app/config/database.php';

echo "Testing database connection...<br>";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    echo "Connection successful!<br>";
    echo "Connected to: " . $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "<br>";
    
    // Test if we can query the database
    $stmt = $conn->query("SHOW TABLES");
    echo "<br>Tables in database:<br>";
    
    $tableCount = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tableCount++;
        echo "- " . reset($row) . "<br>";
    }
    
    echo "<br>Total tables found: " . $tableCount . "<br>";
    
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>