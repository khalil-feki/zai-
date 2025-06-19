<?php
require_once 'config/config.php';
require_once 'app/services/DolibarrService.php';

echo "<h2>URL Debug Information</h2>";

// Check environment variables
echo "<h3>Environment Variables:</h3>";
echo "DOLIBARR_API_URL: " . (getenv('DOLIBARR_API_URL') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_API_KEY: " . (getenv('DOLIBARR_API_KEY') ? 'SET' : 'NOT SET') . "<br>";
echo "DOLIBARR_USERNAME: " . (getenv('DOLIBARR_USERNAME') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_PASSWORD: " . (getenv('DOLIBARR_PASSWORD') ? 'SET' : 'NOT SET') . "<br>";

// Test URL validation
$testUrl = getenv('DOLIBARR_API_URL');
echo "<h3>URL Validation:</h3>";
echo "URL: " . $testUrl . "<br>";
echo "Empty check: " . (empty($testUrl) ? 'EMPTY' : 'NOT EMPTY') . "<br>";
echo "Filter validation: " . (filter_var($testUrl, FILTER_VALIDATE_URL) ? 'VALID' : 'INVALID') . "<br>";

// Test DolibarrService initialization
echo "<h3>DolibarrService Test:</h3>";
try {
    $dolibarr = new DolibarrService();
    echo "DolibarrService initialized successfully<br>";
    
    // Test authentication URL construction
    $reflection = new ReflectionClass($dolibarr);
    $apiUrlProperty = $reflection->getProperty('apiUrl');
    $apiUrlProperty->setAccessible(true);
    $apiUrl = $apiUrlProperty->getValue($dolibarr);
    
    echo "Internal API URL: " . $apiUrl . "<br>";
    $authUrl = $apiUrl . '/api/index.php/login';
    echo "Authentication URL: " . $authUrl . "<br>";
    echo "Auth URL validation: " . (filter_var($authUrl, FILTER_VALIDATE_URL) ? 'VALID' : 'INVALID') . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

echo "<h3>Manual URL Tests:</h3>";
$testUrls = [
    'https://ecommerce.cieloo.io',
    'https://ecommerce.cieloo.io/api/index.php/login',
    '',
    null,
    'invalid-url'
];

foreach ($testUrls as $url) {
    echo "URL: '" . ($url ?? 'NULL') . "' - ";
    echo "Valid: " . (filter_var($url, FILTER_VALIDATE_URL) ? 'YES' : 'NO') . "<br>";
}
?>