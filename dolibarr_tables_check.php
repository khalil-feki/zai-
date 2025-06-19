<?php
require_once 'app/config/config.php';
require_once 'app/utils/DolibarrDatabase.php';

// Create a new instance of the DolibarrDatabase class
$db = new DolibarrDatabase();

// Get all tables
try {
    $tables = $db->getAllTables();
    
    echo "<h1>Dolibarr Database Tables Check</h1>";
    echo "<p>Total tables: " . count($tables) . "</p>";
    
    // Define expected tables and alternatives
    $expectedTables = [
        'product' => ['product'],
        'product_price' => ['product_price', 'product_pricelist', 'product_prices'],
        'product_stock' => ['product_stock', 'stock', 'product_warehouse_properties'],
        'categorie' => ['categorie', 'categories'],
        'categorie_product' => ['categorie_product', 'categories_products', 'category_product'],
        'societe' => ['societe', 'customer', 'clients'],
        'commande' => ['commande', 'orders', 'order'],
        'commandedet' => ['commandedet', 'order_detail', 'orderline']
    ];
    
    echo "<h2>Tables Check:</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Table Type</th><th>Expected Table</th><th>Status</th><th>Alternative Found</th></tr>";
    
    foreach ($expectedTables as $tableType => $possibleTables) {
        $primaryTable = $db->tableExists(DB_PREFIX . $possibleTables[0]);
        $alternativeFound = null;
        
        if (!$primaryTable && count($possibleTables) > 1) {
            for ($i = 1; $i < count($possibleTables); $i++) {
                if ($db->tableExists(DB_PREFIX . $possibleTables[$i])) {
                    $alternativeFound = DB_PREFIX . $possibleTables[$i];
                    break;
                }
            }
        }
        
        echo "<tr>";
        echo "<td>" . $tableType . "</td>";
        echo "<td>" . DB_PREFIX . $possibleTables[0] . "</td>";
        echo "<td>" . ($primaryTable ? "<span style='color:green'>Found</span>" : "<span style='color:red'>Not Found</span>") . "</td>";
        echo "<td>" . ($alternativeFound ? "<span style='color:green'>" . $alternativeFound . "</span>" : ($primaryTable ? "Not needed" : "<span style='color:red'>None found</span>")) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Test product retrieval
    echo "<h2>Sample Products:</h2>";
    try {
        $products = $db->getProducts(5, 0);
        
        if (count($products) > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Reference</th><th>Label</th><th>Description</th><th>Price</th></tr>";
            
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . $product['rowid'] . "</td>";
                echo "<td>" . (isset($product['ref']) ? $product['ref'] : 'N/A') . "</td>";
                echo "<td>" . (isset($product['label']) ? $product['label'] : (isset($product['name']) ? $product['name'] : 'N/A')) . "</td>";
                echo "<td>" . (isset($product['description']) ? substr($product['description'], 0, 100) . "..." : 'N/A') . "</td>";
                echo "<td>" . (isset($product['price']) ? $product['price'] : 'N/A') . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No products found.</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Error retrieving products: " . $e->getMessage() . "</p>";
    }
    
    // Test category retrieval
    echo "<h2>Sample Categories:</h2>";
    try {
        $categories = $db->getCategories();
        
        if (count($categories) > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Label</th><th>Description</th></tr>";
            
            foreach ($categories as $category) {
                echo "<tr>";
                echo "<td>" . $category['rowid'] . "</td>";
                echo "<td>" . (isset($category['label']) ? $category['label'] : (isset($category['name']) ? $category['name'] : 'N/A')) . "</td>";
                echo "<td>" . (isset($category['description']) ? substr($category['description'], 0, 100) . "..." : 'N/A') . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No categories found.</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Error retrieving categories: " . $e->getMessage() . "</p>";
    }
    
    // List all tables
    echo "<h2>All Available Tables:</h2>";
    echo "<div style='height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;'>";
    echo "<ul>";
    foreach ($tables as $table) {
        echo "<li>" . $table . "</li>";
    }
    echo "</ul>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p>Failed to connect to the Dolibarr database: " . $e->getMessage() . "</p>";
}
?>