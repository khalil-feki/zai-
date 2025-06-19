<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your database configuration
require_once 'app/config/database.php';
require_once 'app/models/Product.php';

echo "<h1>Product Debug Tool</h1>";

try {
    // Create product model
    $productModel = new Product();
    
    echo "<h2>Database Connection</h2>";
    echo "<p style='color:green'>Database connection successful!</p>";
    
    // Test direct database query
    echo "<h2>Direct Database Query</h2>";
    $db = new Database();
    $conn = $db->getConnection();
    
    $query = "SELECT rowid, ref, label, price, tosell FROM h8pd_product LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $directProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Found " . count($directProducts) . " products with direct query</p>";
    
    if (count($directProducts) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Reference</th><th>Label</th><th>Price</th><th>For Sale</th></tr>";
        
        foreach ($directProducts as $product) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($product['rowid']) . "</td>";
            echo "<td>" . htmlspecialchars($product['ref']) . "</td>";
            echo "<td>" . htmlspecialchars($product['label']) . "</td>";
            echo "<td>" . htmlspecialchars($product['price']) . "</td>";
            echo "<td>" . (isset($product['tosell']) && $product['tosell'] == 1 ? 'Yes' : 'No') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
    
    // Test Product model methods
    echo "<h2>Product Model Tests</h2>";
    
    // Test 1: findAll without tosell filter
    $productModel->setTosellFilter(false);
    $allProducts = $productModel->findAll();
    echo "<p>findAll() without tosell filter: Found " . count($allProducts) . " products</p>";
    
    // Test 2: findAll with tosell filter
    $productModel->setTosellFilter(true);
    $sellableProducts = $productModel->findAll();
    echo "<p>findAll() with tosell filter: Found " . count($sellableProducts) . " products</p>";
    
    // Test 3: Search method
    $searchResults = $productModel->search("pc");
    echo "<p>search('pc'): Found " . count($searchResults) . " products</p>";
    
    // Test 4: findByAttribute
    $attrResults = $productModel->findByAttribute("label", "pc", "LIKE");
    echo "<p>findByAttribute('label', 'pc', 'LIKE'): Found " . count($attrResults) . " products</p>";
    
    // Test 5: findByTag
    $tagResults = $productModel->findByTag("pc");
    echo "<p>findByTag('pc'): Found " . count($tagResults) . " products</p>";
    
    // Display the first product from each method
    if (count($allProducts) > 0) {
        echo "<h3>Sample Product from findAll()</h3>";
        displayProduct($allProducts[0]);
    }
    
    if (count($searchResults) > 0) {
        echo "<h3>Sample Product from search('pc')</h3>";
        displayProduct($searchResults[0]);
    }
    
    // Check image paths
    echo "<h2>Image Path Tests</h2>";
    $imagePaths = [
        'public/uploads/products/',
        'public/images/products/',
        'public/img/products/'
    ];
    
    foreach ($imagePaths as $path) {
        echo "<p>Checking path: " . $path . " - ";
        if (file_exists($path) && is_dir($path)) {
            echo "<span style='color:green'>Directory exists</span></p>";
            $files = scandir($path);
            $imageFiles = array_filter($files, function($file) {
                return pathinfo($file, PATHINFO_EXTENSION) == 'jpg' || 
                       pathinfo($file, PATHINFO_EXTENSION) == 'png';
            });
            echo "<p>Found " . count($imageFiles) . " image files</p>";
        } else {
            echo "<span style='color:red'>Directory does not exist</span></p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}

function displayProduct($product) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Property</th><th>Value</th></tr>";
    
    foreach ($product as $key => $value) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($key) . "</td>";
        echo "<td>" . htmlspecialchars($value) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}
?>