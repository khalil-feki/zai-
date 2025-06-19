<?php
// Test API Authentication Script
require_once 'app/config/env.php';

echo "<h2>🔐 Dolibarr API Authentication Test</h2>";
echo "<hr>";

// Step 1: Check environment variables
echo "<h3>Step 1: Environment Variables</h3>";
echo "API URL: " . env('DOLIBARR_API_URL', 'NOT SET') . "<br>";
echo "API Key: " . (env('DOLIBARR_API_KEY') ? '***' . substr(env('DOLIBARR_API_KEY'), -4) : 'NOT SET') . "<br>";
echo "Username: " . env('DOLIBARR_USERNAME', 'NOT SET') . "<br>";
echo "Password: " . (env('DOLIBARR_PASSWORD') ? '***' : 'NOT SET') . "<br><br>";

// Step 2: Test different API endpoints
$apiUrl = env('DOLIBARR_API_URL');
$apiKey = env('DOLIBARR_API_KEY');

if (!$apiUrl || !$apiKey) {
    echo "<div style='color: red;'>❌ Missing API URL or API Key in .env file</div>";
    exit;
}

echo "<h3>Step 2: Testing API Endpoints</h3>";

// Test endpoints to try
$endpoints = [
    'status' => '/status',
    'users' => '/users',
    'thirdparties' => '/thirdparties?limit=1',
    'products' => '/products?limit=1'
];

foreach ($endpoints as $name => $endpoint) {
    echo "<h4>Testing {$name} endpoint:</h4>";
    
    $url = $apiUrl . $endpoint;
    echo "URL: {$url}<br>";
    
    $curl = curl_init();
    
    $headers = [
        'DOLAPIKEY: ' . $apiKey,
        'Content-Type: application/json'
    ];
    
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
        CURLOPT_VERBOSE => false
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    curl_close($curl);
    
    if ($err) {
        echo "<div style='color: red;'>❌ cURL Error: {$err}</div><br>";
    } else {
        echo "HTTP Code: {$httpCode}<br>";
        
        if ($httpCode == 200) {
            echo "<div style='color: green;'>✅ Success!</div>";
            $decodedResponse = json_decode($response, true);
            if ($decodedResponse) {
                echo "<pre>" . json_encode($decodedResponse, JSON_PRETTY_PRINT) . "</pre>";
            } else {
                echo "Response: " . htmlspecialchars($response) . "<br>";
            }
        } else {
            echo "<div style='color: red;'>❌ HTTP Error {$httpCode}</div>";
            echo "Response: " . htmlspecialchars($response) . "<br>";
        }
    }
    
    echo "<hr>";
}

// Step 3: Test with different authentication methods
echo "<h3>Step 3: Testing Alternative Authentication</h3>";

// Try with Authorization header instead of DOLAPIKEY
echo "<h4>Testing with Authorization header:</h4>";
$url = $apiUrl . '/status';

$curl = curl_init();

$headers = [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
];

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($curl);
$err = curl_error($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

if ($err) {
    echo "<div style='color: red;'>❌ cURL Error: {$err}</div><br>";
} else {
    echo "HTTP Code: {$httpCode}<br>";
    
    if ($httpCode == 200) {
        echo "<div style='color: green;'>✅ Authorization header works!</div>";
    } else {
        echo "<div style='color: red;'>❌ Authorization header failed</div>";
    }
    echo "Response: " . htmlspecialchars($response) . "<br>";
}

echo "<hr>";

// Step 4: Recommendations
echo "<h3>Step 4: Troubleshooting Recommendations</h3>";
echo "<ul>";
echo "<li>If all endpoints return 401/403: Check if the API key is correct</li>";
echo "<li>If all endpoints return 404: Check if the API URL is correct</li>";
echo "<li>If all endpoints return 500: Check Dolibarr server logs</li>";
echo "<li>If connection fails: Check if Dolibarr server is accessible</li>";
echo "<li>Check Dolibarr admin panel: Setup → Modules → API/Web services → REST API</li>";
echo "<li>Check user permissions: Users → [Your User] → Rights → API</li>";
echo "</ul>";

echo "<h3>Next Steps:</h3>";
echo "<p>If authentication is working, you can proceed to test order creation.</p>";
echo "<p>If authentication is failing, please check the Dolibarr configuration as mentioned above.</p>";
?>