<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

echo "<h2>🔍 Dolibarr Order Placement Diagnostic</h2>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;font-weight:bold;} .error{color:red;font-weight:bold;} .warning{color:orange;font-weight:bold;} .info{color:blue;} .section{background:#f5f5f5;padding:15px;margin:10px 0;border-left:4px solid #007cba;} .code{background:#f0f0f0;padding:10px;font-family:monospace;border:1px solid #ddd;}</style>";

echo "<div class='section'>";
echo "<h3>📋 Step 1: Environment & Service Initialization</h3>";

// Check environment variables
echo "<p><strong>Environment Variables:</strong></p>";
echo "<ul>";
echo "<li>API URL: " . (env('DOLIBARR_API_URL') ? "<span class='success'>✓ " . env('DOLIBARR_API_URL') . "</span>" : "<span class='error'>✗ Missing</span>") . "</li>";
echo "<li>API Key: " . (env('DOLIBARR_API_KEY') ? "<span class='success'>✓ Present (" . strlen(env('DOLIBARR_API_KEY')) . " chars)</span>" : "<span class='error'>✗ Missing</span>") . "</li>";
echo "<li>Username: " . (env('DOLIBARR_USERNAME') ? "<span class='success'>✓ " . env('DOLIBARR_USERNAME') . "</span>" : "<span class='error'>✗ Missing</span>") . "</li>";
echo "</ul>";

// Initialize service
try {
    $dolibarr = new DolibarrService();
    echo "<p><span class='success'>✓ DolibarrService initialized successfully</span></p>";
echo "</div>";
} catch (Exception $e) {
    echo "<p><span class='error'>✗ Failed to initialize DolibarrService: " . $e->getMessage() . "</span></p>";
    echo "</div>";
    exit;
}

echo "<div class='section'>";
echo "<h3>🔐 Step 2: API Authentication Test</h3>";
$authResult = $dolibarr->authenticate();
if ($authResult) {
    echo "<p><span class='success'>✓ API authentication successful</span></p>";
echo "</div>";
} else {
    echo "<p><span class='error'>✗ API authentication failed</span></p>";
    echo "<p><strong>Troubleshooting:</strong></p>";
    echo "<ul>";
    echo "<li>Verify your API key is correct in .env file</li>";
    echo "<li>Check that REST API module is enabled in Dolibarr</li>";
    echo "<li>Ensure user has API access permissions</li>";
    echo "</ul>";
    echo "</div>";
    exit;
}

echo "<div class='section'>";
echo "<h3>👥 Step 3: Customer Verification</h3>";
echo "<p>Checking for available customers (required for orders)...</p>";

// Get customers using a direct API call
$apiUrl = env('DOLIBARR_API_URL') . '/thirdparties?limit=5';
$apiKey = env('DOLIBARR_API_KEY');

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['DOLAPIKEY: ' . $apiKey, 'Content-Type: application/json'],
    CURLOPT_SSL_VERIFYPEER => false
]);
$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode >= 400) {
    $customers = ['error' => 'HTTP Error ' . $httpCode, 'message' => $response];
} else {
    $customers = json_decode($response, true);
}
if (isset($customers['error'])) {
    echo "<p><span class='error'>✗ Failed to fetch customers: " . $customers['error'] . "</span></p>";
    if (isset($customers['message'])) {
        echo "<p class='info'>Details: " . $customers['message'] . "</p>";
    }
echo "</div>";
} else {
    if (empty($customers)) {
        echo "<p><span class='warning'>⚠ No customers found in Dolibarr</span></p>";
        echo "<p><strong>Action Required:</strong> Create at least one customer in Dolibarr before placing orders.</p>";
        echo "<p>Go to Dolibarr → Third Parties → New Third Party</p>";
        $validCustomerId = null;
    } else {
        echo "<p><span class='success'>✓ Found " . count($customers) . " customer(s)</span></p>";
        echo "<p><strong>Available Customers:</strong></p>";
        echo "<ul>";
        foreach (array_slice($customers, 0, 3) as $customer) {
            echo "<li>ID: " . $customer['id'] . " - " . ($customer['name'] ?? 'Unnamed') . "</li>";
        }
        echo "</ul>";
        $validCustomerId = $customers[0]['id'];
        echo "<p class='info'>Will use Customer ID: <strong>" . $validCustomerId . "</strong> for test order</p>";
    }
echo "</div>";
}

echo "<div class='section'>";
echo "<h3>📦 Step 4: Product Verification</h3>";
echo "<p>Checking for available products (required for order lines)...</p>";

$products = $dolibarr->getProducts(5, 0);
if (isset($products['error'])) {
    echo "<p><span class='error'>✗ Failed to fetch products: " . $products['error'] . "</span></p>";
    if (isset($products['message'])) {
        echo "<p class='info'>Details: " . $products['message'] . "</p>";
    }
echo "</div>";
} else {
    if (empty($products)) {
        echo "<p><span class='warning'>⚠ No products found in Dolibarr</span></p>";
        echo "<p><strong>Action Required:</strong> Create at least one product in Dolibarr before placing orders.</p>";
        echo "<p>Go to Dolibarr → Products/Services → New Product</p>";
        $validProductIds = [];
    } else {
        echo "<p><span class='success'>✓ Found " . count($products) . " product(s)</span></p>";
        echo "<p><strong>Available Products:</strong></p>";
        echo "<ul>";
        $validProductIds = [];
        foreach (array_slice($products, 0, 3) as $product) {
            echo "<li>ID: " . $product['id'] . " - " . ($product['label'] ?? 'Unnamed') . " (Price: " . ($product['price'] ?? 'N/A') . ")</li>";
            $validProductIds[] = $product['id'];
        }
        echo "</ul>";
        echo "<p class='info'>Will use Product IDs: <strong>" . implode(', ', array_slice($validProductIds, 0, 2)) . "</strong> for test order</p>";
    }
echo "</div>";
}

// Only proceed with order creation if we have valid customer and products
if (isset($validCustomerId) && !empty($validProductIds)) {
    echo "<div class='section'>";
    echo "<h3>🛒 Step 5: Test Order Creation</h3>";
    
    $orderData = [
        'socid' => $validCustomerId,
        'ref_client' => 'DEBUG-ORDER-' . date('YmdHis'),
        'date' => date('Y-m-d'),
        'note_public' => 'Debug test order - safe to delete',
        'note_private' => 'Created by debug_order_placement.php script',
        'lines' => []
    ];
    
    // Add up to 2 products to the order
    foreach (array_slice($validProductIds, 0, 2) as $index => $productId) {
        $orderData['lines'][] = [
            'fk_product' => $productId,
            'qty' => 1,
            'subprice' => 10.00 + ($index * 5), // Simple pricing
            'desc' => 'Debug test product ' . ($index + 1)
        ];
    }
    
    echo "<p><strong>Order Data:</strong></p>";
    echo "<div class='code'>" . json_encode($orderData, JSON_PRETTY_PRINT) . "</div>";
    
    echo "<p>Creating order...</p>";
    $result = $dolibarr->createDraftOrder($orderData);
    
    if (isset($result['error'])) {
        echo "<p><span class='error'>✗ Order creation failed: " . $result['error'] . "</span></p>";
        if (isset($result['message'])) {
            echo "<p class='info'>Details: " . $result['message'] . "</p>";
        }
        echo "<p><strong>Common Issues:</strong></p>";
        echo "<ul>";
        echo "<li>User lacks order creation permissions</li>";
        echo "<li>Required fields missing (check Dolibarr setup)</li>";
        echo "<li>Products not properly configured</li>";
        echo "<li>Customer account issues</li>";
        echo "</ul>";
    } else {
        echo "<p><span class='success'>✓ Order created successfully!</span></p>";
        $orderId = isset($result['id']) ? $result['id'] : $result;
        echo "<p><strong>Order ID:</strong> " . $orderId . "</p>";
        echo "<p><strong>Reference:</strong> " . $orderData['ref_client'] . "</p>";
        
        // Try to validate the order
        echo "<p>Attempting to validate order...</p>";
        $validateResult = $dolibarr->validateOrder($orderId);
        if (isset($validateResult['error'])) {
            echo "<p><span class='warning'>⚠ Order validation failed: " . $validateResult['error'] . "</span></p>";
            echo "<p class='info'>Order created but remains in draft status</p>";
        } else {
            echo "<p><span class='success'>✓ Order validated successfully!</span></p>";
        }
        
        echo "<div style='background:#e8f5e8;padding:15px;margin:20px 0;border-left:4px solid #4CAF50;'>";
        echo "<h4>🎉 Success!</h4>";
        echo "<p>Your Dolibarr integration is working correctly!</p>";
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ul>";
        echo "<li>Check the order in Dolibarr: Commercial → Orders</li>";
        echo "<li>Look for reference: <strong>" . $orderData['ref_client'] . "</strong></li>";
        echo "<li>Your application can now create orders successfully</li>";
        echo "</ul>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='section'>";
    echo "<h3>❌ Cannot Proceed with Order Creation</h3>";
    echo "<p><span class='error'>Missing required data for order creation:</span></p>";
    echo "<ul>";
    if (!isset($validCustomerId)) {
        echo "<li>No valid customers found</li>";
    }
    if (empty($validProductIds)) {
        echo "<li>No valid products found</li>";
    }
    echo "</ul>";
    
    echo "<p><strong>Required Actions:</strong></p>";
    echo "<ol>";
    echo "<li><strong>Create Customers:</strong> Go to Dolibarr → Third Parties → New Third Party</li>";
    echo "<li><strong>Create Products:</strong> Go to Dolibarr → Products/Services → New Product</li>";
    echo "<li><strong>Re-run this diagnostic</strong> after creating the required data</li>";
    echo "</ol>";
    echo "</div>";
}

echo "<div class='section'>";
echo "<h3>🔧 Additional Tools</h3>";
echo "<p>";
echo "<a href='place_test_order.php' style='margin-right:10px;'>Try Original Order Script</a>";
echo "<a href='diagnose_corrected_api.php' style='margin-right:10px;'>API Diagnostics</a>";
echo "<a href='dolibarr_status.php' style='margin-right:10px;'>Dolibarr Status</a>";
echo "</p>";
echo "</div>";
?>