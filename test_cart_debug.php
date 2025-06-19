<?php
require_once 'app/config/database.php';
require_once 'app/models/Cart.php';

// Test database connection
try {
    $database = new Database();
    $conn = $database->getConnection();
    echo "Database connection: OK\n";
    
    // Test if cart table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'h8pd_cart'");
    if ($stmt->rowCount() > 0) {
        echo "Cart table exists: OK\n";
    } else {
        echo "Cart table missing: ERROR\n";
    }
    
    // Test if product table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'h8pd_product'");
    if ($stmt->rowCount() > 0) {
        echo "Product table exists: OK\n";
    } else {
        echo "Product table missing: ERROR\n";
    }
    
    // Test the exact query from getCartItems method
    $userId = 1; // Change this to a valid user ID
    echo "\nTesting cart query with user ID: $userId\n";
    
    $query = "SELECT c.*, p.label, p.price, p.ref, p.rowid as product_id,
                     p.image_name, p.image_path,
                     (c.quantity * p.price) as total_price
              FROM h8pd_cart c 
              INNER JOIN h8pd_product p ON c.fk_product = p.rowid 
              WHERE c.fk_user = :user_id
              ORDER BY c.datec DESC";
    
    echo "Query: $query\n\n";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "Query preparation failed: ERROR\n";
        print_r($conn->errorInfo());
    } else {
        echo "Query preparation: OK\n";
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result = $stmt->execute();
        
        if (!$result) {
            echo "Query execution failed: ERROR\n";
            print_r($stmt->errorInfo());
        } else {
            echo "Query execution: OK\n";
            echo "Cart items count: " . $stmt->rowCount() . "\n";
            
            // Show some sample data
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "Item: " . $row['label'] . " - Qty: " . $row['quantity'] . "\n";
            }
        }
    }
    
    // Also test the Cart model method
    echo "\n--- Testing Cart Model Method ---\n";
    $cart = new Cart();
    $result = $cart->getCartItems($userId);
    
    if ($result === false) {
        echo "Cart model getCartItems failed: ERROR\n";
    } else {
        echo "Cart model getCartItems: OK\n";
        echo "Cart items count: " . $result->rowCount() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>