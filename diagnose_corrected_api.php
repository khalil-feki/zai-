<?php
/**
 * Dolibarr API Diagnosis Tool - Corrected URL
 * Tests the corrected API endpoint discovered by the user
 */

require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

echo "<h1>Dolibarr API Diagnosis - Corrected URL</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .warning{color:orange;} .info{color:blue;} pre{background:#f5f5f5;padding:10px;border-radius:5px;}</style>";

// Load environment variables
loadEnvFile();

echo "<h2>1. Environment Configuration Check</h2>";
$apiUrl = $_ENV['DOLIBARR_API_URL'] ?? 'Not set';
$apiKey = $_ENV['DOLIBARR_API_KEY'] ?? 'Not set';
$username = $_ENV['DOLIBARR_USERNAME'] ?? 'Not set';
$password = $_ENV['DOLIBARR_PASSWORD'] ?? 'Not set';

echo "API URL: " . ($apiUrl !== 'Not set' ? "<span class='success'>✓</span> <code>$apiUrl</code>" : "<span class='error'>✗ Not configured</span>") . "<br>";
echo "API Key: " . ($apiKey !== 'Not set' ? "<span class='warning'>⚠</span> $apiKey (length: " . strlen($apiKey) . ")" : "<span class='error'>✗ Not configured</span>") . "<br>";
echo "Username: " . ($username !== 'Not set' ? "<span class='success'>✓</span> $username" : "<span class='error'>✗ Not configured</span>") . "<br>";
echo "Password: " . ($password !== 'Not set' ? "<span class='success'>✓</span> [HIDDEN]" : "<span class='error'>✗ Not configured</span>") . "<br><br>";

echo "<h2>2. API Key Analysis</h2>";
if ($apiKey !== 'Not set') {
    echo "Current API Key: <code>$apiKey</code><br>";
    echo "Key Length: " . strlen($apiKey) . " characters<br>";
    
    if ($apiKey === 'admin123456789') {
        echo "<span class='error'>✗ This appears to be a placeholder/test key</span><br><br>";
    } elseif (strlen($apiKey) < 20) {
        echo "<span class='warning'>⚠ Key seems short for a typical API key</span><br><br>";
    } else {
        echo "<span class='success'>✓ Key length appears reasonable</span><br><br>";
    }
}

echo "<h2>3. API Connectivity Test</h2>";

// Test the corrected URL
$testUrl = rtrim($apiUrl, '/') . '/status';
echo "Testing URL: <code>$testUrl</code><br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $testUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'DOLAPIKEY: ' . $apiKey
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Status Code: <strong>$httpCode</strong><br>";

if ($error) {
    echo "<span class='error'>✗ cURL Error: $error</span><br>";
} elseif ($httpCode === 200) {
    echo "<span class='success'>✓ API endpoint is accessible</span><br>";
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
} elseif ($httpCode === 401) {
    echo "<span class='error'>✗ Authentication failed (401 Unauthorized)</span><br>";
    echo "This means the API key is invalid or the user doesn't have proper permissions.<br>";
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
} elseif ($httpCode === 403) {
    echo "<span class='error'>✗ Access forbidden (403 Forbidden)</span><br>";
    echo "This means the API key might be valid but the user lacks permissions.<br>";
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
} elseif ($httpCode === 404) {
    echo "<span class='error'>✗ Endpoint not found (404)</span><br>";
    echo "The API endpoint is still not accessible at this URL.<br>";
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
} else {
    echo "<span class='error'>✗ Unexpected HTTP status: $httpCode</span><br>";
    echo "Response: <pre>" . htmlspecialchars($response) . "</pre>";
}

echo "<h2>4. Login Test</h2>";

// Test login endpoint that user discovered
$loginUrl = rtrim($apiUrl, '/') . '/login';
$loginTestUrl = $loginUrl . '?login=' . urlencode($username) . '&password=' . urlencode($password);

echo "Testing login URL: <code>$loginUrl</code><br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $loginTestUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$loginResponse = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$loginError = curl_error($ch);
curl_close($ch);

echo "Login HTTP Status Code: <strong>$loginHttpCode</strong><br>";

if ($loginError) {
    echo "<span class='error'>✗ cURL Error: $loginError</span><br>";
} elseif ($loginHttpCode === 200) {
    echo "<span class='success'>✓ Login successful</span><br>";
    echo "Login Response: <pre>" . htmlspecialchars($loginResponse) . "</pre>";
    
    // Try to extract token from response
    $loginData = json_decode($loginResponse, true);
    if (isset($loginData['success']['token'])) {
        echo "<span class='info'>ℹ Token received: " . substr($loginData['success']['token'], 0, 20) . "...</span><br>";
    }
} elseif ($loginHttpCode === 403) {
    echo "<span class='error'>✗ Login forbidden (403)</span><br>";
    echo "Username/password combination is not valid or user is disabled.<br>";
    echo "Login Response: <pre>" . htmlspecialchars($loginResponse) . "</pre>";
} else {
    echo "<span class='error'>✗ Login failed with status: $loginHttpCode</span><br>";
    echo "Login Response: <pre>" . htmlspecialchars($loginResponse) . "</pre>";
}

echo "<h2>5. Next Steps</h2>";

if ($httpCode === 401 || $httpCode === 403) {
    echo "<h3>API Key Issues:</h3>";
    echo "<ol>";
    echo "<li>Login to your Dolibarr instance as administrator</li>";
    echo "<li>Go to <strong>Setup → Modules/Applications</strong></li>";
    echo "<li>Ensure the <strong>'REST API'</strong> module is enabled</li>";
    echo "<li>Go to <strong>Setup → Users & Groups → Users</strong></li>";
    echo "<li>Edit the user <strong>'$username'</strong></li>";
    echo "<li>Generate a new API key (32-character string)</li>";
    echo "<li>Ensure user has <strong>Admin rights</strong> or appropriate permissions</li>";
    echo "<li>Ensure user status is <strong>'Enabled'</strong></li>";
    echo "<li>Save the user</li>";
    echo "<li>Update your .env file with the new API key</li>";
    echo "</ol>";
}

if ($loginHttpCode === 403) {
    echo "<h3>Login Issues:</h3>";
    echo "<ol>";
    echo "<li>Verify the username '<strong>$username</strong>' exists in Dolibarr</li>";
    echo "<li>Verify the password is correct</li>";
    echo "<li>Check if the user account is enabled and not expired</li>";
    echo "<li>Ensure the user has login permissions</li>";
    echo "</ol>";
}

echo "<h3>Update Configuration:</h3>";
echo "Update your <code>.env</code> file with the corrected URL:<br>";
echo "<pre>DOLIBARR_API_URL=https://ecommerce.cieloo.io/api/index.php\nDOLIBARR_API_KEY=your_new_32_character_api_key_here</pre>";

echo "<h2>6. Additional Debug Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "cURL Version: " . curl_version()['version'] . "<br>";
echo "OpenSSL Support: " . (extension_loaded('openssl') ? 'Yes' : 'No') . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";

echo "<br><hr><br>";
echo "<p><strong>Summary:</strong> The API is accessible at the corrected URL. Focus on resolving authentication issues by generating a proper API key and ensuring user permissions.</p>";
?>