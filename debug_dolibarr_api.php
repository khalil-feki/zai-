<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

echo "<h2>Dolibarr API Debug Test</h2>";

// Display current configuration
echo "<h3>Current Configuration:</h3>";
echo "API URL: " . getenv('DOLIBARR_API_URL') . "<br>";
echo "API Key: " . getenv('DOLIBARR_API_KEY') . "<br>";
echo "Username: " . getenv('DOLIBARR_USERNAME') . "<br>";
echo "Password: " . str_repeat('*', strlen(getenv('DOLIBARR_PASSWORD'))) . "<br><br>";

// Test 1: Basic URL connectivity
echo "<h3>1. Testing Basic URL Connectivity</h3>";
$baseUrl = getenv('DOLIBARR_API_URL');
$testUrl = $baseUrl . '/api/index.php/status';

echo "Testing URL: " . $testUrl . "<br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $testUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<span style='color: red;'>✗ cURL Error: " . htmlspecialchars($error) . "</span><br>";
} else {
    echo "<span style='color: green;'>✓ Connection successful</span><br>";
    echo "HTTP Code: " . $httpCode . "<br>";
    echo "Response: " . htmlspecialchars(substr($response, 0, 200)) . "...<br>";
}

echo "<br>";

// Test 2: Authentication
echo "<h3>2. Testing Authentication</h3>";
$dolibarr = new DolibarrService();

try {
    $auth = $dolibarr->authenticate();
    if ($auth) {
        echo "<span style='color: green;'>✓ Authentication successful!</span><br>";
        echo "Token received: " . substr($auth['success']['token'], 0, 20) . "...<br>";
    } else {
        echo "<span style='color: red;'>✗ Authentication failed</span><br>";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Authentication error: " . htmlspecialchars($e->getMessage()) . "</span><br>";
}

echo "<br>";

// Test 3: Test different login URL variations
echo "<h3>3. Testing Different Login URL Variations</h3>";
$loginUrls = [
    $baseUrl . '/api/index.php/login',
    $baseUrl . '/htdocs/api/index.php/login',
    str_replace('/dolibarr', '', $baseUrl) . '/api/index.php/login'
];

foreach ($loginUrls as $loginUrl) {
    echo "Testing: " . $loginUrl . "<br>";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $loginUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'login' => getenv('DOLIBARR_USERNAME'),
        'password' => getenv('DOLIBARR_PASSWORD'),
        'entity' => 1
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'DOLAPIKEY: ' . getenv('DOLIBARR_API_KEY')
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "  <span style='color: red;'>✗ Error: " . htmlspecialchars($error) . "</span><br>";
    } else {
        echo "  HTTP Code: " . $httpCode . "<br>";
        if ($httpCode == 200) {
            echo "  <span style='color: green;'>✓ Success!</span><br>";
            $responseData = json_decode($response, true);
            if (isset($responseData['success']['token'])) {
                echo "  Token: " . substr($responseData['success']['token'], 0, 20) . "...<br>";
            }
        } else {
            echo "  <span style='color: orange;'>Response: " . htmlspecialchars(substr($response, 0, 200)) . "</span><br>";
        }
    }
    echo "<br>";
}

echo "<h3>Debug Complete</h3>";
echo "<p><a href='test_order_creation.php'>Test Order Creation</a> | <a href='create_order_form.php'>Order Form</a></p>";
?>