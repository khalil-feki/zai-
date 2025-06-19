<?php
require_once 'app/config/database.php';

// Create database connection
$db = new Database();
$conn = $db->getConnection();

echo "<h1>Assign Product Images</h1>";

try {
    // First, let's see what products we have
    $query = "SELECT rowid, ref, label FROM h8pd_product LIMIT 405";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Available Products:</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Reference</th><th>Label</th><th>Action</th></tr>";
    
    foreach ($products as $product) {
        echo "<tr>";
        echo "<td>" . $product['rowid'] . "</td>";
        echo "<td>" . htmlspecialchars($product['ref']) . "</td>";
        echo "<td>" . htmlspecialchars($product['label']) . "</td>";
        echo "<td>";
        echo "<a href='?action=assign&product_id=" . $product['rowid'] . "&image=001_etiquette_codes_barres_4030_ma.jpg'>Assign Barcode Image</a> | ";
        echo "<a href='?action=assign&product_id=" . $product['rowid'] . "&image=Etiquette ANTIVOL RF 4x4.jpg'>Assign Antivol Image</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Handle image assignment
    if (isset($_GET['action']) && $_GET['action'] == 'assign') {
        $productId = $_GET['product_id'];
        $imageName = $_GET['image'];
        
        // Check if image_name column exists, if not add it
        try {
            $checkColumn = "SHOW COLUMNS FROM h8pd_product LIKE 'image_name'";
            $stmt = $conn->prepare($checkColumn);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                // Add image_name column
                $addColumn = "ALTER TABLE h8pd_product ADD COLUMN image_name VARCHAR(255) NULL";
                $conn->exec($addColumn);
                echo "<p style='color:green'>Added image_name column to h8pd_product table.</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color:orange'>Note: " . $e->getMessage() . "</p>";
        }
        
        // Update product with image name
        $updateQuery = "UPDATE h8pd_product SET image_name = :image_name WHERE rowid = :product_id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':image_name', $imageName);
        $stmt->bindParam(':product_id', $productId);
        
        if ($stmt->execute()) {
            echo "<p style='color:green'>Successfully assigned image '$imageName' to product ID $productId!</p>";
        } else {
            echo "<p style='color:red'>Failed to assign image.</p>";
        }
    }
    
    echo "<h2>Available Images:</h2>";
    $imageDir = 'public/img/products/';
    $images = ['001_etiquette_codes_barres_4030_ma.jpg', 'Etiquette ANTIVOL RF 4x4.jpg'];
    
    foreach ($images as $image) {
        if (file_exists($imageDir . $image)) {
            echo "<p><img src='" . $imageDir . $image . "' style='max-width:200px; max-height:150px;'> - " . $image . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>