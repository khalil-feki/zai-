<?php
require_once 'app/config/env.php';

// Load environment variables
loadEnvFile();

echo "<h2>Debug Authentication Issue</h2>";
echo "<style>body{font-family:Arial,sans-serif;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Check environment variables
echo "<h3>1. Environment Variables</h3>";
echo "<p><strong>DOLIBARR_API_URL:</strong> " . (getenv('DOLIBARR_API_URL') ?: $_ENV['DOLIBARR_API_URL'] ?? 'NOT SET') . "</p>";
echo "<p><strong>DOLIBARR_API_KEY:</strong> " . (getenv('DOLIBARR_API_KEY') ?: $_ENV['DOLIBARR_API_KEY'] ?? 'NOT SET') . "</p>";

// Test direct API call
echo "<h3>2. Direct API Test</h3>";

$apiUrl = getenv('DOLIBARR_API_URL') ?: $_ENV['DOLIBARR_API_URL'];
$apiKey = getenv('DOLIBARR_API_KEY') ?: $_ENV['DOLIBARR_API_KEY'];

if (empty($apiUrl) || empty($apiKey)) {
    echo "<span class='error'>✗ Missing API URL or API Key</span><br>";
    exit;
}

// Test the status endpoint
$url = $apiUrl . '/status';
echo "<p><strong>Testing URL:</strong> $url</p>";

$curl = curl_init();

$headers = [
    'DOLAPIKEY: ' . $apiKey,
    'Content-Type: application/json'
];

echo "<p><strong>Headers:</strong></p>";
echo "<pre>" . print_r($headers, true) . "</pre>";

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_SSL_VERIFYPEER => false,
]);

$response = curl_exec($curl);
$err = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

echo "<h3>3. Response</h3>";
echo "<p><strong>HTTP Code:</strong> $httpCode</p>";

if ($err) {
    echo "<span class='error'>✗ cURL Error: $err</span><br>";
} else {
    echo "<p><strong>Response:</strong></p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    
    $decodedResponse = json_decode($response, true);
    
    if ($httpCode == 200 && !isset($decodedResponse['error'])) {
        echo "<span class='success'>✓ Authentication successful!</span><br>";
    } else {
        echo "<span class='error'>✗ Authentication failed</span><br>";
        if (isset($decodedResponse['error'])) {
            echo "<p><strong>Error:</strong> " . $decodedResponse['error'] . "</p>";
        }
    }
}

// Test DolibarrService class
echo "<h3>4. DolibarrService Test</h3>";

try {
    require_once 'app/services/DolibarrService.php';
    $dolibarr = new DolibarrService();
    echo "<span class='success'>✓ DolibarrService initialized</span><br>";
    
    $auth = $dolibarr->authenticate();
    if ($auth) {
        echo "<span class='success'>✓ DolibarrService authentication successful</span><br>";
    } else {
        echo "<span class='error'>✗ DolibarrService authentication failed</span><br>";
    }
} catch (Exception $e) {
    echo "<span class='error'>✗ DolibarrService error: " . $e->getMessage() . "</span><br>";
}

echo "<br><h3>Recommendations</h3>";
echo "<ul>";
echo "<li>If HTTP Code is 200 but DolibarrService fails, check the service implementation</li>";
echo "<li>If HTTP Code is 401/403, verify the API key in Dolibarr admin panel</li>";
echo "<li>If HTTP Code is 404, check the API URL structure</li>";
echo "<li>If HTTP Code is 500, check Dolibarr server logs</li>";
echo "</ul>";
?>