<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

echo "<h2>Test Dolibarr API Authentication</h2>";

// Test environment variables
echo "<h3>Environment Variables:</h3>";
echo "DOLIBARR_API_URL: " . (getenv('DOLIBARR_API_URL') ?: $_ENV['DOLIBARR_API_URL'] ?? 'Not set') . "<br>";
echo "DOLIBARR_API_KEY: " . (getenv('DOLIBARR_API_KEY') ?: $_ENV['DOLIBARR_API_KEY'] ?? 'Not set') . "<br><br>";

// Test DolibarrService initialization
echo "<h3>DolibarrService Initialization:</h3>";
try {
    $dolibarr = new DolibarrService();
    echo "<span style='color: green;'>✓ DolibarrService created successfully</span><br><br>";
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ DolibarrService creation failed: " . $e->getMessage() . "</span><br><br>";
    exit;
}

// Test authentication
echo "<h3>Authentication Test:</h3>";
$auth = $dolibarr->authenticate();
if ($auth) {
    echo "<span style='color: green;'>✓ Authentication successful</span><br><br>";
} else {
    echo "<span style='color: red;'>✗ Authentication failed</span><br><br>";
}

// Test a simple API call
echo "<h3>API Call Test (Get Status):</h3>";
$url = (getenv('DOLIBARR_API_URL') ?: $_ENV['DOLIBARR_API_URL'] ?? 'https://ecommerce.cieloo.io') . '/api/index.php/status';

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'DOLAPIKEY: ' . (getenv('DOLIBARR_API_KEY') ?: $_ENV['DOLIBARR_API_KEY'] ?? 'admin123456789'),
        'Content-Type: application/json'
    ],
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error = curl_error($curl);
curl_close($curl);

echo "URL: " . $url . "<br>";
echo "HTTP Code: " . $httpCode . "<br>";
if ($error) {
    echo "<span style='color: red;'>cURL Error: " . $error . "</span><br>";
} else {
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
}

echo "<br><h3>Test Complete</h3>";
?>