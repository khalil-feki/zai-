<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database configuration
require_once 'app/config/database.php';

echo "<h1>Database Connection Test</h1>";

try {
    // Create database connection
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "<p style='color:green'>Successfully connected to the database!</p>";
    
    // Test query to the h8pd_product table
    $query = "SELECT COUNT(*) as count FROM h8pd_product";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Found " . $result['count'] . " products in the h8pd_product table.</p>";
    
    // Show all products in the table
    $query = "SELECT rowid, ref, label, price, tosell FROM h8pd_product";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($products) > 0) {
        echo "<h2>All Products:</h2>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Reference</th><th>Label</th><th>Price</th><th>For Sale</th></tr>";
        
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['rowid']) . "</td>";
            echo "<td>" . htmlspecialchars($product['ref']) . "</td>";
            echo "<td>" . htmlspecialchars($product['label']) . "</td>";
            echo "<td>" . htmlspecialchars($product['price']) . "</td>";
            echo "<td>" . (isset($product['tosell']) && $product['tosell'] == 1 ? 'Yes' : 'No') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No products found in the database.</p>";
    }
    
    // Show database table structure
    echo "<h2>Table Structure:</h2>";
    $query = "DESCRIBE h8pd_product";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($columns) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        foreach ($columns as $column) {
            echo "<tr>";
            foreach ($column as $key => $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>Database connection failed: " . $e->getMessage() . "</p>";
    
    // Get database configuration from the Database class if possible
    echo "<h2>Database Configuration:</h2>";
    try {
        $dbConfig = new ReflectionClass('Database');
        $constants = $dbConfig->getConstants();
        
        foreach ($constants as $name => $value) {
            if (strpos($name, 'PASS') === false) { // Don't show password
                echo "<p>" . $name . ": " . $value . "</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p>Could not retrieve database configuration details.</p>";
    }
}
?>