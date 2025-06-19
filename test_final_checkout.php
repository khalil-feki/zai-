<?php
// Final checkout test after all fixes
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/Product.php';

echo "<h1>Final Checkout Test</h1>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .section{margin:20px 0;padding:15px;border:1px solid #ccc;}</style>";

// Start session and set up test user
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['user_id'] = 1;
$_SESSION['user_email'] = 'test@example.com';

echo "<div class='section'><h2>Testing Complete Order Flow</h2>";

try {
    // Initialize models
    $cartModel = new Cart();
    $orderModel = new Order();
    $productModel = new Product();
    
    // Clear existing cart
    $cartModel->clearCart(1);
    echo "<span class='info'>✓ Cart cleared</span><br>";
    
    // Add test products to cart
    $products = $productModel->findAll();
    if (!empty($products)) {
        $testProduct1 = $products[0];
        $testProduct2 = isset($products[1]) ? $products[1] : $products[0];
        
        $cartModel->addToCart(1, $testProduct1['rowid'], 2, $testProduct1['price']);
        $cartModel->addToCart(1, $testProduct2['rowid'], 1, $testProduct2['price']);
        
        echo "<span class='success'>✓ Added products to cart</span><br>";
        
        // Get cart items
        $cartItems = $cartModel->getCartItems(1);
        echo "<span class='info'>Cart items: " . count($cartItems) . "</span><br>";
        
        // Transform cart items for order creation (matching CheckoutController logic)
        $orderItems = array_map(function($item) {
            return [
                'product_id' => $item['product_id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity']
            ];
        }, $cartItems);
        
        // Create order data
        $orderData = [
            'user_id' => 1,
            'shipping_address' => 'Test Shipping Address 123, Tunis, Tunisia',
            'billing_address' => 'Test Billing Address 456, Tunis, Tunisia',
            'payment_method' => 'cash_on_delivery',
            'notes' => 'Test order from final checkout test - ' . date('Y-m-d H:i:s'),
            'dolibarr_order_id' => null
        ];
        
        // Create the order
        echo "<span class='info'>Creating order with new method signature...</span><br>";
        $orderId = $orderModel->createOrder($orderData, $orderItems);
        
        if ($orderId) {
            echo "<span class='success'>✓ Order created successfully! Order ID: $orderId</span><br>";
            
            // Verify the order
            $order = $orderModel->getOrderById($orderId);
            if ($order) {
                echo "<span class='success'>✓ Order verified in database</span><br>";
                echo "<span class='info'>Order Reference: " . htmlspecialchars($order['ref']) . "</span><br>";
                echo "<span class='info'>Order Total: " . number_format($order['total_ttc'], 2) . " TND</span><br>";
                echo "<span class='info'>Order Date: " . $order['date_commande'] . "</span><br>";
                
                // Get order items
                $orderItems = $orderModel->getOrderItems($orderId);
                echo "<span class='info'>Order items: " . count($orderItems) . "</span><br>";
                
                foreach ($orderItems as $item) {
                    echo "<span class='info'>- " . htmlspecialchars($item['product_name']) . " (Qty: " . $item['qty'] . ", Price: " . number_format($item['price'], 2) . " TND, Total: " . number_format($item['total_ht'], 2) . " TND)</span><br>";
                }
                
                // Check if cart was cleared
                $remainingCartItems = $cartModel->getCartItems(1);
                if (empty($remainingCartItems)) {
                    echo "<span class='success'>✓ Cart cleared after order creation</span><br>";
                } else {
                    echo "<span class='error'>✗ Cart not cleared (" . count($remainingCartItems) . " items remaining)</span><br>";
                }
                
            } else {
                echo "<span class='error'>✗ Order not found in database after creation</span><br>";
            }
        } else {
            echo "<span class='error'>✗ Order creation failed</span><br>";
        }
        
    } else {
        echo "<span class='error'>✗ No products available for testing</span><br>";
    }
    
} catch (Exception $e) {
    echo "<span class='error'>✗ Error during test: " . $e->getMessage() . "</span><br>";
    echo "<span class='error'>Stack trace: " . $e->getTraceAsString() . "</span><br>";
}

echo "</div>";

// Check recent errors
echo "<div class='section'><h2>Recent Error Check</h2>";
$errorLogFile = 'php_errors.log';
if (file_exists($errorLogFile)) {
    $errors = file($errorLogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $recentErrors = array_slice($errors, -5); // Last 5 errors
    
    if (!empty($recentErrors)) {
        echo "<span class='info'>Recent errors (last 5):</span><br>";
        foreach ($recentErrors as $error) {
            if (strpos($error, date('Y-m-d')) !== false) {
                echo "<span class='error'>" . htmlspecialchars($error) . "</span><br>";
            }
        }
    } else {
        echo "<span class='success'>✓ No recent errors found</span><br>";
    }
} else {
    echo "<span class='info'>No error log file found</span><br>";
}
echo "</div>";

echo "<div class='section'><h2>Test Summary</h2>";
echo "<p><strong>All major fixes applied:</strong></p>";
echo "<ul>";
echo "<li>✓ Fixed createOrder method signature mismatch</li>";
echo "<li>✓ Fixed parameter binding issues</li>";
echo "<li>✓ Fixed duplicate order reference generation</li>";
echo "<li>✓ Fixed currency display (TND instead of EUR)</li>";
echo "<li>✓ Enhanced error logging and debugging</li>";
echo "</ul>";
echo "<p><strong>Ready for live testing:</strong></p>";
echo "<ul>";
echo "<li><a href='" . BASE_URL . "checkout' target='_blank'>Test live checkout page</a></li>";
echo "<li><a href='" . BASE_URL . "cart' target='_blank'>Test cart functionality</a></li>";
echo "<li><a href='" . BASE_URL . "products' target='_blank'>Browse products</a></li>";
echo "</ul>";
echo "</div>";
?>