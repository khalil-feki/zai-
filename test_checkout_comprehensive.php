<?php
// Comprehensive checkout diagnostic script
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/models/Product.php';
require_once 'app/controllers/CheckoutController.php';

echo "<h1>Comprehensive Checkout Diagnostic</h1>";
echo "<style>body{font-family:Arial;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} .section{margin:20px 0;padding:15px;border:1px solid #ccc;}</style>";

// Test 1: Database Connection
echo "<div class='section'><h2>1. Database Connection Test</h2>";
try {
    $db = new Database();
    $pdo = $db->getConnection();
    echo "<span class='success'>✓ Database connection successful</span><br>";
} catch (Exception $e) {
    echo "<span class='error'>✗ Database connection failed: " . $e->getMessage() . "</span><br>";
    exit;
}
echo "</div>";

// Test 2: User Authentication
echo "<div class='section'><h2>2. User Authentication Test</h2>";
session_start();
$_SESSION['user_id'] = 1; // Simulate logged in user
$_SESSION['user_email'] = 'test@example.com';

$userModel = new User();
$user = $userModel->getUserById(1);
if ($user) {
    echo "<span class='success'>✓ User found: " . htmlspecialchars($user['email']) . "</span><br>";
} else {
    echo "<span class='error'>✗ User not found</span><br>";
}
echo "</div>";

// Test 3: Cart Functionality
echo "<div class='section'><h2>3. Cart Functionality Test</h2>";
$cartModel = new Cart();

// Clear existing cart
$cartModel->clearCart(1);
echo "<span class='info'>Cart cleared</span><br>";

// Add test items to cart
$productModel = new Product();
$products = $productModel->findAll();
if (!empty($products)) {
    $testProduct = $products[0];
    $cartModel->addToCart(1, $testProduct['rowid'], 2, $testProduct['price']);
    echo "<span class='success'>✓ Added product to cart: " . htmlspecialchars($testProduct['label']) . "</span><br>";
    
    $cartItems = $cartModel->getCartItems(1);
    echo "<span class='info'>Cart items count: " . count($cartItems) . "</span><br>";
    
    foreach ($cartItems as $item) {
        echo "<span class='info'>- " . htmlspecialchars($item['label']) . " (Qty: " . $item['quantity'] . ", Price: " . $item['price'] . " TND)</span><br>";
    }
} else {
    echo "<span class='error'>✗ No products available for testing</span><br>";
}
echo "</div>";

// Test 4: Order Creation
echo "<div class='section'><h2>4. Order Creation Test</h2>";
$orderModel = new Order();

// Prepare test order data
$orderData = [
    'user_id' => 1,
    'shipping_address' => 'Test Address 123',
    'billing_address' => 'Test Address 123',
    'payment_method' => 'cash_on_delivery',
    'notes' => 'Test order from diagnostic script',
    'dolibarr_order_id' => null
];

$cartItems = $cartModel->getCartItems(1);
if (!empty($cartItems)) {
    try {
        $orderId = $orderModel->createOrder($orderData, $cartItems);
        if ($orderId) {
            echo "<span class='success'>✓ Order created successfully with ID: $orderId</span><br>";
            
            // Verify order in database
            $order = $orderModel->getOrderById($orderId);
            if ($order) {
                echo "<span class='success'>✓ Order verified in database</span><br>";
                echo "<span class='info'>Order Reference: " . htmlspecialchars($order['ref']) . "</span><br>";
                echo "<span class='info'>Order Total: " . number_format($order['total_ttc'], 2) . " TND</span><br>";
                
                // Get order items
                $orderItems = $orderModel->getOrderItems($orderId);
                echo "<span class='info'>Order items count: " . count($orderItems) . "</span><br>";
            } else {
                echo "<span class='error'>✗ Order not found in database after creation</span><br>";
            }
        } else {
            echo "<span class='error'>✗ Order creation failed</span><br>";
        }
    } catch (Exception $e) {
        echo "<span class='error'>✗ Order creation error: " . $e->getMessage() . "</span><br>";
    }
} else {
    echo "<span class='error'>✗ No cart items available for order creation</span><br>";
}
echo "</div>";

// Test 5: Checkout Controller
echo "<div class='section'><h2>5. Checkout Controller Test</h2>";
try {
    $checkoutController = new CheckoutController();
    echo "<span class='success'>✓ CheckoutController instantiated successfully</span><br>";
    
    // Test checkout page rendering (capture output)
    ob_start();
    $checkoutController->index();
    $output = ob_get_clean();
    
    if (strlen($output) > 100) {
        echo "<span class='success'>✓ Checkout page renders successfully (" . strlen($output) . " characters)</span><br>";
    } else {
        echo "<span class='error'>✗ Checkout page output too short or empty</span><br>";
    }
} catch (Exception $e) {
    echo "<span class='error'>✗ CheckoutController error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

// Test 6: Form Processing Simulation
echo "<div class='section'><h2>6. Form Processing Simulation</h2>";
$_POST = [
    'shipping_address' => 'Test Shipping Address 123',
    'billing_address' => 'Test Billing Address 123',
    'payment_method' => 'cash_on_delivery',
    'notes' => 'Test order notes'
];

echo "<span class='info'>Simulated POST data:</span><br>";
foreach ($_POST as $key => $value) {
    echo "<span class='info'>- $key: " . htmlspecialchars($value) . "</span><br>";
}

try {
    // Simulate the process method (but don't actually run it to avoid redirects)
    echo "<span class='success'>✓ POST data prepared for processing</span><br>";
    echo "<span class='info'>Note: Actual process() method not called to avoid redirects</span><br>";
} catch (Exception $e) {
    echo "<span class='error'>✗ Form processing simulation error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

// Test 7: Recent Error Logs
echo "<div class='section'><h2>7. Recent Error Logs</h2>";
$errorLogFile = 'php_errors.log';
if (file_exists($errorLogFile)) {
    $errors = file($errorLogFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $recentErrors = array_slice($errors, -10); // Last 10 errors
    
    if (!empty($recentErrors)) {
        echo "<span class='info'>Recent errors (last 10):</span><br>";
        foreach ($recentErrors as $error) {
            echo "<span class='error'>" . htmlspecialchars($error) . "</span><br>";
        }
    } else {
        echo "<span class='success'>✓ No recent errors found</span><br>";
    }
} else {
    echo "<span class='info'>No error log file found</span><br>";
}
echo "</div>";

// Test 8: Configuration Check
echo "<div class='section'><h2>8. Configuration Check</h2>";
echo "<span class='info'>BASE_URL: " . BASE_URL . "</span><br>";
echo "<span class='info'>Environment: " . ENVIRONMENT . "</span><br>";
echo "<span class='info'>Session Status: " . (session_status() == PHP_SESSION_ACTIVE ? 'Active' : 'Inactive') . "</span><br>";
echo "<span class='info'>User ID in session: " . ($_SESSION['user_id'] ?? 'Not set') . "</span><br>";
echo "</div>";

echo "<div class='section'><h2>Summary</h2>";
echo "<p>Diagnostic completed. Check each section above for any issues that need to be addressed.</p>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li><a href='" . BASE_URL . "checkout' target='_blank'>Test actual checkout page</a></li>";
echo "<li><a href='" . BASE_URL . "cart' target='_blank'>Test cart page</a></li>";
echo "<li><a href='" . BASE_URL . "products' target='_blank'>Test products page</a></li>";
echo "</ul>";
echo "</div>";
?>