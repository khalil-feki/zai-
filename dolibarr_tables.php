<?php
require_once 'app/config/config.php';
require_once 'app/utils/DolibarrDatabase.php';

// Create a new instance of the DolibarrDatabase class
$db = new DolibarrDatabase();

// Get all tables
try {
    $tables = $db->getAllTables();
    
    echo "<h1>Dolibarr Database Tables</h1>";
    echo "<p>Total tables: " . count($tables) . "</p>";
    
    echo "<h2>Tables used in this project:</h2>";
    echo "<ul>";
    $usedTables = [
        DB_PREFIX . 'product',
        DB_PREFIX . 'product_price',
        DB_PREFIX . 'product_stock',
        DB_PREFIX . 'categorie',
        DB_PREFIX . 'categorie_product',
        DB_PREFIX . 'societe',
        DB_PREFIX . 'commande',
        DB_PREFIX . 'commandedet'
    ];
    
    foreach ($usedTables as $table) {
        $found = in_array($table, $tables);
        echo "<li>" . $table . " - " . ($found ? "<span style='color:green'>Found</span>" : "<span style='color:red'>Not Found</span>") . "</li>";
    }
    echo "</ul>";
    
    echo "<h2>All Available Tables:</h2>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . $table . "</li>";
    }
    echo "</ul>";
    
    // Test product retrieval
    echo "<h2>Sample Products:</h2>";
    $products = $db->getProducts(5, 0);
    
    if (count($products) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Reference</th><th>Label</th><th>Description</th><th>Price</th></tr>";
        
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $product['rowid'] . "</td>";
            echo "<td>" . $product['ref'] . "</td>";
            echo "<td>" . $product['label'] . "</td>";
            echo "<td>" . substr($product['description'], 0, 100) . "...</td>";
            echo "<td>" . $product['price'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>No products found.</p>";
    }
    
} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p>Failed to connect to the Dolibarr database: " . $e->getMessage() . "</p>";
}
?>