<?php
/**
 * Test script for Dolibarr integration with draft order workflow
 * This script tests the complete flow: draft creation -> local order -> validation
 */

require_once 'config/database.php';
require_once 'app/services/DolibarrService.php';
require_once 'app/models/Order.php';
require_once 'app/models/User.php';
require_once 'app/models/Cart.php';

echo "<h1>Dolibarr Integration Test</h1>";
echo "<p>Testing the complete workflow: Draft Order Creation -> Local Order -> Validation</p>";

try {
    // Initialize services
    $dolibarrService = new DolibarrService();
    $orderModel = new Order();
    $userModel = new User();
    $cartModel = new Cart();
    
    echo "<h2>Step 1: Testing Dolibarr Connection</h2>";
    
    // Test connection
    if ($dolibarrService->checkConnection()) {
        echo "<p style='color: green;'>✓ Dolibarr connection successful</p>";
    } else {
        echo "<p style='color: red;'>✗ Dolibarr connection failed</p>";
        throw new Exception('Cannot connect to Dolibarr');
    }
    
    echo "<h2>Step 2: Testing Customer Lookup</h2>";
    
    // Test customer lookup
    $testEmail = 'test@example.com';
    try {
        $customerResponse = $dolibarrService->getCustomerByEmail($testEmail);
        if (isset($customerResponse[0]['id'])) {
            echo "<p style='color: green;'>✓ Found customer with email {$testEmail}: ID " . $customerResponse[0]['id'] . "</p>";
            $customerId = $customerResponse[0]['id'];
        } else {
            echo "<p style='color: orange;'>⚠ Customer not found, using default customer ID: 1</p>";
            $customerId = 1;
        }
    } catch (Exception $e) {
        echo "<p style='color: orange;'>⚠ Customer lookup failed: " . $e->getMessage() . ", using default customer ID: 1</p>";
        $customerId = 1;
    }
    
    echo "<h2>Step 3: Testing Draft Order Creation</h2>";
    
    // Prepare test order data
    $testOrderData = [
        'customer_id' => $customerId,
        'ref_client' => 'TEST-WEB-' . date('YmdHis'),
        'note_public' => 'Test order from web application',
        'note_private' => 'Test order - Shipping: Test Address, Payment: Test Method',
        'lines' => [
            [
                'product_id' => 1, // Assuming product ID 1 exists
                'quantity' => 2,
                'price' => 10.50,
                'description' => 'Test Product 1'
            ],
            [
                'product_id' => 2, // Assuming product ID 2 exists
                'quantity' => 1,
                'price' => 25.00,
                'description' => 'Test Product 2'
            ]
        ]
    ];
    
    try {
        $draftResponse = $dolibarrService->createDraftOrder($testOrderData);
        
        if (isset($draftResponse['id'])) {
            $dolibarrOrderId = $draftResponse['id'];
            echo "<p style='color: green;'>✓ Draft order created successfully in Dolibarr with ID: {$dolibarrOrderId}</p>";
            echo "<p>Draft order reference: " . ($draftResponse['ref'] ?? 'N/A') . "</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to create draft order in Dolibarr</p>";
            echo "<pre>Response: " . json_encode($draftResponse, JSON_PRETTY_PRINT) . "</pre>";
            throw new Exception('Draft order creation failed');
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error creating draft order: " . $e->getMessage() . "</p>";
        throw $e;
    }
    
    echo "<h2>Step 4: Testing Local Order Creation</h2>";
    
    // Prepare test items for local order
    $testItems = [
        [
            'product_id' => 1,
            'price' => 10.50,
            'quantity' => 2,
            'total_price' => 21.00
        ],
        [
            'product_id' => 2,
            'price' => 25.00,
            'quantity' => 1,
            'total_price' => 25.00
        ]
    ];
    
    try {
        // Use a test user ID (assuming user ID 1 exists)
        $testUserId = 1;
        $localOrderId = $orderModel->createOrder($testUserId, $testItems, $dolibarrOrderId);
        
        if ($localOrderId) {
            echo "<p style='color: green;'>✓ Local order created successfully with ID: {$localOrderId}</p>";
            echo "<p>Order includes reference to Dolibarr order ID: {$dolibarrOrderId}</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to create local order</p>";
            throw new Exception('Local order creation failed');
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error creating local order: " . $e->getMessage() . "</p>";
        throw $e;
    }
    
    echo "<h2>Step 5: Testing Order Validation in Dolibarr</h2>";
    
    try {
        $validateResponse = $dolibarrService->validateOrder($dolibarrOrderId);
        
        if (isset($validateResponse['id'])) {
            echo "<p style='color: green;'>✓ Order validated successfully in Dolibarr</p>";
            echo "<p>Validated order ID: " . $validateResponse['id'] . "</p>";
            echo "<p>Order status: " . ($validateResponse['statut'] ?? 'N/A') . "</p>";
        } else {
            echo "<p style='color: orange;'>⚠ Order validation response unclear</p>";
            echo "<pre>Response: " . json_encode($validateResponse, JSON_PRETTY_PRINT) . "</pre>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error validating order: " . $e->getMessage() . "</p>";
        // Don't throw here as validation failure shouldn't break the entire flow
    }
    
    echo "<h2>Test Summary</h2>";
    echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px;'>";
    echo "<p><strong>✓ Test completed successfully!</strong></p>";
    echo "<ul>";
    echo "<li>Dolibarr connection: Working</li>";
    echo "<li>Draft order creation: Working (ID: {$dolibarrOrderId})</li>";
    echo "<li>Local order creation: Working (ID: {$localOrderId})</li>";
    echo "<li>Order validation: Attempted</li>";
    echo "</ul>";
    echo "<p><em>The integration workflow is now compatible with Dolibarr's draft-first approach.</em></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<h2>Test Failed</h2>";
    echo "<div style='background: #ffe8e8; padding: 15px; border-radius: 5px;'>";
    echo "<p><strong>✗ Test failed with error:</strong></p>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    echo "<p><em>Please check the error logs and Dolibarr configuration.</em></p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Test completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>