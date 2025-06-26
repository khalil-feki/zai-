<?php
require_once 'app/config/database.php';

// Create database connection
$db = new Database();
$conn = $db->getConnection();

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Assign Product Images</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }";
echo "h1, h2 { color: #333; }";
echo "table { border-collapse: collapse; width: 100%; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }";
echo "th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }";
echo "th { background-color: #f8f9fa; font-weight: bold; }";
echo "tr:nth-child(even) { background-color: #f9f9f9; }";
echo "select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; background-color: white; }";
echo ".success { color: green; background-color: #d4edda; padding: 10px; border-radius: 4px; margin: 10px 0; }";
echo ".error { color: red; background-color: #f8d7da; padding: 10px; border-radius: 4px; margin: 10px 0; }";
echo ".image-gallery { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; }";
echo ".image-item { background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<h1>Assign Product Images</h1>";
echo "<form id='batchAssignForm' method='post' action=''>";
echo "<div style='margin-bottom: 20px;'>";
echo "<button type='submit' name='apply_changes' style='background-color: #28a745; color: white; padding: 12px 24px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;'>Apply All Changes</button>";
echo "<button type='button' onclick='clearAll()' style='background-color: #dc3545; color: white; padding: 12px 24px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; margin-left: 10px;'>Clear All</button>";
echo "</div>";

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
        echo "<select name='product_images[" . $product['rowid'] . "]' id='select_" . $product['rowid'] . "'>";
        echo "<option value=''>Select Image...</option>";
        echo "<option value='001_etiquette_codes_barres_4030_ma.jpg'>Barcode Image</option>";
        echo "<option value='Etiquette ANTIVOL RF 4x4.jpg'>Antivol Image</option>";
        echo "<option value='1.png'>Image 1</option>";
        echo "<option value='2.png'>Image 2</option>";
        echo "<option value='3.png'>Image 3</option>";
        echo "<option value='4.png'>Image 4</option>";
        echo "<option value='5.png'>Image 5</option>";
        echo "<option value='6.png'>Image 6</option>";
        echo "<option value='7.png'>Image 7</option>";
        echo "<option value='8.png'>Image 8</option>";
        echo "<option value='9.png'>Image 9</option>";
        echo "<option value='10.png'>Image 10</option>";
        echo "<option value='11.png'>Image 11</option>";
        echo "</select>";
        

        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";
    
    echo "<script>";
    echo "function clearAll() {";
    echo "  var selects = document.querySelectorAll('select[name^=\"product_images\"]');";
    echo "  selects.forEach(function(select) { select.value = ''; });";
    echo "}";
    echo "</script>";
    
    // Handle batch image assignment
    if (isset($_POST['apply_changes']) && isset($_POST['product_images'])) {
        // Check if image_name column exists, if not add it
        try {
            $checkColumn = "SHOW COLUMNS FROM h8pd_product LIKE 'image_name'";
            $stmt = $conn->prepare($checkColumn);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                // Add image_name column
                $addColumn = "ALTER TABLE h8pd_product ADD COLUMN image_name VARCHAR(255) NULL";
                $conn->exec($addColumn);
                echo "<div class='success'>Added image_name column to h8pd_product table.</div>";
            }
        } catch (Exception $e) {
            echo "<div class='error'>Note: " . $e->getMessage() . "</div>";
        }
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($_POST['product_images'] as $productId => $imageName) {
            if (!empty($imageName)) {
                // Update product with image name
                $updateQuery = "UPDATE h8pd_product SET image_name = :image_name WHERE rowid = :product_id";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bindParam(':image_name', $imageName);
                $stmt->bindParam(':product_id', $productId);
                
                if ($stmt->execute()) {
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }
        }
        
        if ($successCount > 0) {
            echo "<div class='success'>Successfully assigned images to $successCount product(s)!</div>";
        }
        if ($errorCount > 0) {
            echo "<div class='error'>Failed to assign images to $errorCount product(s).</div>";
        }
    }
    
    echo "<h2>Available Images:</h2>";
    $imageDir = 'public/img/products/';
    $webImageDir = '/zai/public/img/products/';
    $images = [
        '001_etiquette_codes_barres_4030_ma.jpg',
        'Etiquette ANTIVOL RF 4x4.jpg',
        '1.png',
        '2.png',
        '3.png',
        '4.png',
        '5.png',
        '6.png',
        '7.png',
        '8.png',
        '9.png',
        '10.png',
        '11.png'
    ];
    
    echo "<div class='image-gallery'>";
    foreach ($images as $image) {
        if (file_exists($imageDir . $image)) {
            echo "<div class='image-item'>";
            echo "<img src='" . $webImageDir . $image . "' style='max-width:200px; max-height:150px; border:1px solid #ddd;'><br>";
            echo "<small>" . htmlspecialchars($image) . "</small>";
            echo "</div>";
        } else {
            echo "<div class='error'>Image not found: " . htmlspecialchars($image) . "</div>";
        }
    }
    echo "</div>";
    echo "</body></html>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
?>