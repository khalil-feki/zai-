<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';
require_once 'app/models/Order.php';
require_once 'app/config/database.php';

echo "<h2>Test Order Creation Process</h2>";

// Test database connection
echo "<h3>1. Testing Database Connection</h3>";
try {
    $database = new Database();
    $conn = $database->getConnection();
    echo "<span style='color: green;'>✓ Database connection successful</span><br><br>";
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</span><br><br>";
    exit;
}

// Test Dolibarr API connection
echo "<h3>2. Testing Dolibarr API Connection</h3>";
$dolibarr = new DolibarrService();
$auth = $dolibarr->authenticate();
if ($auth) {
    echo "<span style='color: green;'>✓ Dolibarr authentication successful</span><br><br>";
} else {
    echo "<span style='color: red;'>✗ Dolibarr authentication failed</span><br><br>";
}

// Test order creation with corrected data structure
echo "<h3>3. Testing Order Creation</h3>";

// Prepare test order data with correct field names for Dolibarr API
$testOrderData = [
    'socid' => 1, // Customer ID (using socid for Dolibarr)
    'ref_client' => 'TEST-' . date('YmdHis'),
    'note_public' => 'Test order - Product: Test Product, Quantity: 1',
    'note_private' => 'Test order created from debug script',
    'date' => date('Y-m-d'),
    'lines' => [
        [
            'fk_product' => 1,     // Product ID (using fk_product for Dolibarr)
            'qty' => 1,           // Quantity (using qty for Dolibarr)
            'subprice' => 10.00,  // Unit price (using subprice for Dolibarr)
            'desc' => 'Test Product Description'
        ]
    ]
];

echo "<h4>Order data to send to Dolibarr:</h4>";
echo "<pre>" . htmlspecialchars(json_encode($testOrderData, JSON_PRETTY_PRINT)) . "</pre>";

// Try to create order in Dolibarr
echo "<h4>Creating order in Dolibarr...</h4>";
$dolibarrResult = $dolibarr->createDraftOrder($testOrderData);

if (isset($dolibarrResult['error'])) {
    echo "<span style='color: red;'>✗ Dolibarr order creation failed:</span><br>";
    echo "Error: " . htmlspecialchars($dolibarrResult['error']) . "<br>";
    if (isset($dolibarrResult['message'])) {
        echo "Details: " . htmlspecialchars($dolibarrResult['message']) . "<br>";
    }
    echo "<br>";
} else {
    echo "<span style='color: green;'>✓ Dolibarr order created successfully!</span><br>";
    echo "Response: <pre>" . htmlspecialchars(json_encode($dolibarrResult, JSON_PRETTY_PRINT)) . "</pre>";
    
    // Now test local order creation
    echo "<h4>Creating local order...</h4>";
    $order = new Order();
    
    // Prepare local order items with correct structure
    $localOrderItems = [
        [
            'product_id' => 1,
            'quantity' => 1,
            'price' => 10.00,
            'total_price' => 10.00
        ]
    ];
    
    $dolibarrId = isset($dolibarrResult['id']) ? $dolibarrResult['id'] : (isset($dolibarrResult['rowid']) ? $dolibarrResult['rowid'] : null);
    $localOrderId = $order->createOrder(1, $localOrderItems, $dolibarrId);
    
    if ($localOrderId) {
        echo "<span style='color: green;'>✓ Local order created successfully!</span><br>";
        echo "Local Order ID: " . $localOrderId . "<br>";
        echo "Dolibarr Order ID: " . ($dolibarrId ?? 'N/A') . "<br>";
    } else {
        echo "<span style='color: red;'>✗ Local order creation failed</span><br>";
    }
}

echo "<br><h3>Test Complete</h3>";
echo "<p><a href='create_order_form.php'>Go to Order Form</a></p>";
?>