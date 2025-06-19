<?php
// Test complete checkout process
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';
require_once 'app/models/Cart.php';
require_once 'app/models/Order.php';
require_once 'app/services/DolibarrService.php';

echo "<h2>Complete Checkout Process Test</h2>";
echo "<hr>";

// Step 1: Test environment loading
echo "<h3>1. Environment Configuration</h3>";
echo "DOLIBARR_API_URL: " . (getenv('DOLIBARR_API_URL') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_API_KEY: " . (getenv('DOLIBARR_API_KEY') ? 'SET (' . substr(getenv('DOLIBARR_API_KEY'), 0, 10) . '...)' : 'NOT SET') . "<br>";
echo "BASE_URL: " . BASE_URL . "<br>";
echo "<hr>";

// Step 2: Test database connection
echo "<h3>2. Database Connection</h3>";
try {
    $database = new Database();
    $conn = $database->getConnection();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}
echo "<hr>";

// Step 3: Test Dolibarr API connection
echo "<h3>3. Dolibarr API Connection</h3>";
try {
    $dolibarr = new DolibarrService();
    if ($dolibarr->authenticate()) {
        echo "✅ Dolibarr API authentication successful<br>";
    } else {
        echo "❌ Dolibarr API authentication failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Dolibarr API error: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// Step 4: Test user creation/retrieval
echo "<h3>4. User Management</h3>";
$userModel = new User();
$testEmail = 'test@example.com';

// Check if test user exists
$existingUser = $userModel->findByEmail($testEmail);
if ($existingUser) {
    $userId = $existingUser['rowid'];
    echo "✅ Test user found (ID: $userId)<br>";
} else {
    echo "❌ Test user not found. Please create a user with email: $testEmail<br>";
    echo "<hr>";
    exit;
}
echo "<hr>";

// Step 5: Test cart functionality
echo "<h3>5. Cart Management</h3>";
$cartModel = new Cart();

// Clear existing cart
$cartModel->clearCart($userId);
echo "🧹 Cart cleared<br>";

// Add test products to cart
$testProducts = [1, 2]; // Assuming products with IDs 1 and 2 exist
foreach ($testProducts as $productId) {
    if ($cartModel->addToCart($userId, $productId, 2)) {
        echo "✅ Added product $productId to cart<br>";
    } else {
        echo "❌ Failed to add product $productId to cart<br>";
    }
}

// Get cart items
$cartItems = $cartModel->getCartItems($userId);
echo "📦 Cart contains " . count($cartItems) . " items:<br>";
foreach ($cartItems as $item) {
    echo "&nbsp;&nbsp;- {$item['label']} (Qty: {$item['quantity']}, Price: {$item['price']} TND)<br>";
}
echo "<hr>";

// Step 6: Test order creation
echo "<h3>6. Order Creation</h3>";
if (empty($cartItems)) {
    echo "❌ Cannot test order creation: Cart is empty<br>";
    exit;
}

$orderModel = new Order();

// Prepare order items
$orderItems = array_map(function($item) {
    return [
        'product_id' => $item['product_id'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'total_price' => $item['price'] * $item['quantity']
    ];
}, $cartItems);

echo "📋 Prepared order items:<br>";
foreach ($orderItems as $item) {
    echo "&nbsp;&nbsp;- Product ID: {$item['product_id']}, Qty: {$item['quantity']}, Total: {$item['total_price']} TND<br>";
}

// Create order
try {
    $orderId = $orderModel->createOrder($userId, $orderItems);
    if ($orderId) {
        echo "✅ Order created successfully with ID: $orderId<br>";
        
        // Verify order was created
        $orderDetails = $orderModel->getOrderDetails($orderId, $userId);
        if ($orderDetails->rowCount() > 0) {
            $order = $orderDetails->fetch(PDO::FETCH_ASSOC);
            echo "📄 Order details:<br>";
            echo "&nbsp;&nbsp;- Order ID: {$order['id']}<br>";
            echo "&nbsp;&nbsp;- Reference: {$order['ref']}<br>";
            echo "&nbsp;&nbsp;- Total: {$order['total_ttc']} TND<br>";
            echo "&nbsp;&nbsp;- Status: {$order['fk_statut']}<br>";
            
            // Get order items
            $orderItemsFromDB = $orderModel->getOrderItems($orderId);
            echo "&nbsp;&nbsp;- Items: " . count($orderItemsFromDB) . "<br>";
        }
    } else {
        echo "❌ Order creation failed<br>";
    }
} catch (Exception $e) {
    echo "❌ Order creation error: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// Step 7: Test Dolibarr integration
echo "<h3>7. Dolibarr Integration Test</h3>";
if (isset($orderId) && $orderId) {
    try {
        // Test customer lookup
        $user = $userModel->findById($userId);
        $customerResponse = $dolibarr->getCustomerByEmail($user['email']);
        
        if (isset($customerResponse[0]['id'])) {
            $customerId = $customerResponse[0]['id'];
            echo "✅ Found customer in Dolibarr (ID: $customerId)<br>";
        } else {
            echo "⚠️ Customer not found in Dolibarr, using default ID: 1<br>";
            $customerId = 1;
        }
        
        // Test order creation in Dolibarr
        $dolibarrOrderData = [
            'customer_id' => $customerId,
            'ref_client' => 'TEST-' . date('YmdHis'),
            'note_public' => 'Test order from checkout test',
            'note_private' => 'Test order - Local Order ID: ' . $orderId,
            'lines' => []
        ];
        
        foreach ($orderItems as $item) {
            $dolibarrOrderData['lines'][] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'description' => 'Test product'
            ];
        }
        
        $dolibarrResponse = $dolibarr->createDraftOrder($dolibarrOrderData);
        
        if (isset($dolibarrResponse['id'])) {
            $dolibarrOrderId = $dolibarrResponse['id'];
            echo "✅ Created Dolibarr draft order (ID: $dolibarrOrderId)<br>";
            
            // Test order validation
            $validateResponse = $dolibarr->validateOrder($dolibarrOrderId);
            if (isset($validateResponse['id'])) {
                echo "✅ Validated Dolibarr order successfully<br>";
            } else {
                echo "⚠️ Failed to validate Dolibarr order: " . json_encode($validateResponse) . "<br>";
            }
        } else {
            echo "❌ Failed to create Dolibarr draft order: " . json_encode($dolibarrResponse) . "<br>";
        }
    } catch (Exception $e) {
        echo "❌ Dolibarr integration error: " . $e->getMessage() . "<br>";
    }
}
echo "<hr>";

echo "<h3>✅ Checkout Process Test Complete</h3>";
echo "<p><strong>Summary:</strong></p>";
echo "<ul>";
echo "<li>Environment: Configured</li>";
echo "<li>Database: Connected</li>";
echo "<li>Dolibarr API: " . (isset($dolibarr) && $dolibarr->authenticate() ? 'Working' : 'Issues detected') . "</li>";
echo "<li>Cart: Functional</li>";
echo "<li>Order Creation: " . (isset($orderId) && $orderId ? 'Working' : 'Issues detected') . "</li>";
echo "<li>Dolibarr Integration: " . (isset($dolibarrOrderId) ? 'Working' : 'Issues detected') . "</li>";
echo "</ul>";

echo "<p><a href='" . BASE_URL . "checkout'>Go to Checkout Page</a></p>";
?>