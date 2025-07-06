<?php
require_once 'app/config/database.php';

// Create database connection
$db = new Database();
$conn = $db->getConnection();

echo "<h1>Fixing Product Images</h1>";

try {
    // Check if image_name column exists, if not add it
    $checkColumn = "SHOW COLUMNS FROM h8pd_product LIKE 'image_name'";
    $stmt = $conn->prepare($checkColumn);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        // Add image_name column
        $addColumn = "ALTER TABLE h8pd_product ADD COLUMN image_name VARCHAR(255) NULL";
        $conn->exec($addColumn);
        echo "<p style='color:green'>Added image_name column to h8pd_product table.</p>";
    }
    
    // Get all products
    $query = "SELECT rowid FROM h8pd_product ORDER BY rowid";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $availableImages = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png', '8.png', '9.png', '10.png', '11.png'];
    $imageCount = count($availableImages);
    $successCount = 0;
    
    foreach ($products as $index => $product) {
        // Assign images in a round-robin fashion
        $imageIndex = $index % $imageCount;
        $imageName = $availableImages[$imageIndex];
        
        // Update product with image name
        $updateQuery = "UPDATE h8pd_product SET image_name = :image_name WHERE rowid = :product_id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':image_name', $imageName);
        $stmt->bindParam(':product_id', $product['rowid']);
        
        if ($stmt->execute()) {
            $successCount++;
            echo "<p>Product ID {$product['rowid']} assigned image: {$imageName}</p>";
        }
    }
    
    echo "<p style='color:green; font-weight:bold'>Successfully assigned images to {$successCount} products!</p>";
    echo "<p><a href='/zai/product/view/1'>Test Product View</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>