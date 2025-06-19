<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

echo "<h2>Place Test Order in Dolibarr</h2>";
echo "<style>body{font-family:Arial,sans-serif;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Initialize Dolibarr service
try {
    $dolibarr = new DolibarrService();
    echo "<span class='success'>✓ DolibarrService initialized</span><br><br>";
} catch (Exception $e) {
    echo "<span class='error'>✗ Failed to initialize DolibarrService: " . $e->getMessage() . "</span><br>";
    exit;
}

// Test authentication
echo "<h3>1. Testing Authentication</h3>";
$auth = $dolibarr->authenticate();
if ($auth) {
    echo "<span class='success'>✓ Authentication successful</span><br><br>";
} else {
    echo "<span class='error'>✗ Authentication failed - please check your API key</span><br>";
    echo "<p><a href='diagnose_api_key.php'>Diagnose API Key Issues</a></p>";
    exit;
}

// Create a test order
echo "<h3>2. Creating Test Order</h3>";

// Prepare order data
$orderData = [
    'socid' => 1, // Customer ID (assuming customer with ID 1 exists)
    'ref_client' => 'TEST-ORDER-' . date('YmdHis'),
    'date' => date('Y-m-d'),
    'note_public' => 'Test order created from web interface',
    'note_private' => 'This is a test order to verify Dolibarr integration',
    'lines' => [
        [
            'fk_product' => 1, // Product ID (assuming product with ID 1 exists)
            'qty' => 2,
            'subprice' => 25.00,
            'desc' => 'Test Product - Sample Item'
        ],
        [
            'fk_product' => 2, // Another product (if exists)
            'qty' => 1,
            'subprice' => 50.00,
            'desc' => 'Another Test Product'
        ]
    ]
];

echo "<p><strong>Order Details:</strong></p>";
echo "<ul>";
echo "<li>Customer ID: " . $orderData['socid'] . "</li>";
echo "<li>Reference: " . $orderData['ref_client'] . "</li>";
echo "<li>Date: " . $orderData['date'] . "</li>";
echo "<li>Products: " . count($orderData['lines']) . " items</li>";
echo "</ul>";

// Create the order
try {
    $result = $dolibarr->createDraftOrder($orderData);
    
    if (isset($result['error'])) {
        echo "<span class='error'>✗ Order creation failed: " . $result['error'] . "</span><br>";
        if (isset($result['message'])) {
            echo "<span class='error'>Message: " . $result['message'] . "</span><br>";
        }
        echo "<pre>" . print_r($result, true) . "</pre>";
    } else {
        echo "<span class='success'>✓ Order created successfully!</span><br>";
        echo "<p><strong>Order ID:</strong> " . (isset($result['id']) ? $result['id'] : $result) . "</p>";
        
        // If we have an order ID, try to validate it
        if (isset($result['id']) || is_numeric($result)) {
            $orderId = isset($result['id']) ? $result['id'] : $result;
            echo "<h3>3. Validating Order</h3>";
            
            $validateResult = $dolibarr->validateOrder($orderId);
            if (isset($validateResult['error'])) {
                echo "<span class='error'>✗ Order validation failed: " . $validateResult['error'] . "</span><br>";
            } else {
                echo "<span class='success'>✓ Order validated successfully!</span><br>";
            }
        }
        
        echo "<div style='background:#e8f5e8;padding:15px;margin:20px 0;border-left:4px solid #4CAF50;'>";
        echo "<h4>🎉 Success!</h4>";
        echo "<p>Your test order has been successfully placed in Dolibarr.</p>";
        echo "<p><strong>What to do next:</strong></p>";
        echo "<ul>";
        echo "<li>Log into your Dolibarr instance</li>";
        echo "<li>Go to Commercial → Orders</li>";
        echo "<li>Look for order reference: <strong>" . $orderData['ref_client'] . "</strong></li>";
        echo "<li>You should see the order with the test products</li>";
        echo "</ul>";
        echo "</div>";
    }
} catch (Exception $e) {
    echo "<span class='error'>✗ Exception during order creation: " . $e->getMessage() . "</span><br>";
}

echo "<br><h3>Additional Actions</h3>";
echo "<p>";
echo "<a href='diagnose_api_key.php' style='margin-right:10px;'>Diagnose API</a>";
echo "<a href='test_order_creation.php' style='margin-right:10px;'>Test Order Creation</a>";
echo "<a href='dolibarr_status.php' style='margin-right:10px;'>Dolibarr Status</a>";
echo "</p>";
?>