<?php
require_once 'app/config/env.php';

echo "<h2>Dolibarr API Key Diagnosis</h2>";
echo "<style>body{font-family:Arial,sans-serif;} .error{color:red;} .success{color:green;} .warning{color:orange;} .info{color:blue;}</style>";

// Check environment variables
echo "<h3>1. Environment Configuration Check</h3>";
$apiUrl = getenv('DOLIBARR_API_URL') ?: $_ENV['DOLIBARR_API_URL'] ?? null;
$apiKey = getenv('DOLIBARR_API_KEY') ?: $_ENV['DOLIBARR_API_KEY'] ?? null;
$username = getenv('DOLIBARR_USERNAME') ?: $_ENV['DOLIBARR_USERNAME'] ?? null;
$password = getenv('DOLIBARR_PASSWORD') ?: $_ENV['DOLIBARR_PASSWORD'] ?? null;

echo "API URL: " . ($apiUrl ? "<span class='success'>✓ $apiUrl</span>" : "<span class='error'>✗ Not configured</span>") . "<br>";
echo "API Key: " . ($apiKey ? "<span class='warning'>⚠ $apiKey (length: " . strlen($apiKey) . ")</span>" : "<span class='error'>✗ Not configured</span>") . "<br>";
echo "Username: " . ($username ? "<span class='success'>✓ $username</span>" : "<span class='error'>✗ Not configured</span>") . "<br>";
echo "Password: " . ($password ? "<span class='success'>✓ [HIDDEN]</span>" : "<span class='error'>✗ Not configured</span>") . "<br><br>";

// API Key Analysis
echo "<h3>2. API Key Analysis</h3>";
if ($apiKey) {
    echo "Current API Key: <code>$apiKey</code><br>";
    echo "Key Length: " . strlen($apiKey) . " characters<br>";
    
    // Check if it looks like a real API key
    if ($apiKey === 'admin123456789') {
        echo "<span class='error'>✗ This appears to be a placeholder/test key</span><br>";
    } elseif (strlen($apiKey) < 20) {
        echo "<span class='warning'>⚠ API key seems too short for a real Dolibarr key</span><br>";
    } elseif (preg_match('/^[a-f0-9]{32,}$/i', $apiKey)) {
        echo "<span class='success'>✓ Key format looks like a valid hash</span><br>";
    } else {
        echo "<span class='warning'>⚠ Key format doesn't match typical Dolibarr API keys</span><br>";
    }
} else {
    echo "<span class='error'>✗ No API key found</span><br>";
}
echo "<br>";

// Test API connectivity
echo "<h3>3. API Connectivity Test</h3>";
if ($apiUrl && $apiKey) {
    $testUrl = $apiUrl . '/api/index.php/status';
    echo "Testing URL: <code>$testUrl</code><br>";
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $testUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'DOLAPIKEY: ' . $apiKey,
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_VERBOSE => false
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);
    
    echo "HTTP Status Code: <strong>$httpCode</strong><br>";
    
    if ($error) {
        echo "<span class='error'>✗ cURL Error: $error</span><br>";
    } elseif ($httpCode === 200) {
        echo "<span class='success'>✓ API connection successful!</span><br>";
        echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
    } elseif ($httpCode === 401) {
        echo "<span class='error'>✗ Authentication failed (401 Unauthorized)</span><br>";
        echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
        
        // Parse the error message
        $responseData = json_decode($response, true);
        if ($responseData && isset($responseData['error']['message'])) {
            $errorMsg = $responseData['error']['message'];
            echo "<br><strong>Error Analysis:</strong><br>";
            
            if (strpos($errorMsg, 'not found with api key') !== false) {
                echo "<span class='error'>• The API key is not associated with any valid user</span><br>";
            }
            if (strpos($errorMsg, 'bad status') !== false) {
                echo "<span class='error'>• The user associated with this API key is disabled</span><br>";
            }
            if (strpos($errorMsg, 'bad validity dates') !== false) {
                echo "<span class='error'>• The user account has expired or is not yet valid</span><br>";
            }
            if (strpos($errorMsg, 'conf->entity=1') !== false) {
                echo "<span class='warning'>• The API is configured for entity 1 (default company)</span><br>";
            }
        }
    } else {
        echo "<span class='error'>✗ Unexpected HTTP status: $httpCode</span><br>";
        echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
    }
} else {
    echo "<span class='error'>✗ Cannot test - missing API URL or API Key</span><br>";
}
echo "<br>";

// Instructions for fixing
echo "<h3>4. How to Fix API Key Issues</h3>";
echo "<div style='background:#f0f0f0;padding:15px;border-left:4px solid #007cba;'>";
echo "<strong>To generate a valid Dolibarr API key:</strong><br><br>";
echo "1. <strong>Login to your Dolibarr instance</strong> as an administrator<br>";
echo "2. <strong>Go to Setup → Modules/Applications</strong><br>";
echo "3. <strong>Enable the 'REST API' module</strong> if not already enabled<br>";
echo "4. <strong>Go to Setup → Users & Groups → Users</strong><br>";
echo "5. <strong>Edit the user you want to use for API access</strong> (e.g., 'khalil')<br>";
echo "6. <strong>In the user form, find the 'Key for API' field</strong><br>";
echo "7. <strong>Generate a new API key</strong> by clicking the generate button or entering a custom one<br>";
echo "8. <strong>Make sure the user has 'Admin' rights</strong> or appropriate permissions<br>";
echo "9. <strong>Make sure the user status is 'Enabled'</strong><br>";
echo "10. <strong>Save the user</strong><br><br>";
echo "<strong>Alternative method via API Explorer:</strong><br>";
echo "• Visit: <code>$apiUrl/api/index.php/explorer</code><br>";
echo "• Use the explorer to test API calls and verify your key<br><br>";
echo "<strong>Update your .env file with the new API key:</strong><br>";
echo "<code>DOLIBARR_API_KEY=your_new_32_character_api_key_here</code><br>";
echo "</div><br>";

// Additional debugging info
echo "<h3>5. Additional Debug Information</h3>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "cURL Version: " . (function_exists('curl_version') ? curl_version()['version'] : 'Not available') . "<br>";
echo "OpenSSL Support: " . (extension_loaded('openssl') ? 'Yes' : 'No') . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";

echo "<br><a href='test_api_auth.php'>← Back to API Auth Test</a> | ";
echo "<a href='test_order_creation.php'>Test Order Creation →</a>";
?>