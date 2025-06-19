<?php
echo "<h2>Environment Loading Debug</h2>";

// Test 1: Check if .env file exists
$envFile = dirname(__FILE__) . '/.env';
echo "<h3>Step 1: .env file check</h3>";
echo "Looking for .env file at: " . $envFile . "<br>";
echo "File exists: " . (file_exists($envFile) ? 'YES' : 'NO') . "<br>";

if (file_exists($envFile)) {
    echo "<h3>Step 2: .env file contents</h3>";
    $content = file_get_contents($envFile);
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
    
    echo "<h3>Step 3: Manual parsing</h3>";
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        echo "Line: '" . htmlspecialchars($line) . "'<br>";
        
        if (strpos(trim($line), '#') === 0) {
            echo "  -> Skipped (comment)<br>";
            continue;
        }
        
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            echo "  -> Setting: $name = $value<br>";
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

echo "<h3>Step 4: Test getenv() after manual loading</h3>";
echo "DOLIBARR_API_URL: " . (getenv('DOLIBARR_API_URL') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_API_KEY: " . (getenv('DOLIBARR_API_KEY') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_USERNAME: " . (getenv('DOLIBARR_USERNAME') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_PASSWORD: " . (getenv('DOLIBARR_PASSWORD') ? 'SET' : 'NOT SET') . "<br>";

echo "<h3>Step 5: Test $_ENV superglobal</h3>";
echo "\$_ENV['DOLIBARR_API_URL']: " . ($_ENV['DOLIBARR_API_URL'] ?? 'NOT SET') . "<br>";
echo "\$_ENV['DOLIBARR_API_KEY']: " . ($_ENV['DOLIBARR_API_KEY'] ?? 'NOT SET') . "<br>";
echo "\$_ENV['DOLIBARR_USERNAME']: " . ($_ENV['DOLIBARR_USERNAME'] ?? 'NOT SET') . "<br>";
echo "\$_ENV['DOLIBARR_PASSWORD']: " . (isset($_ENV['DOLIBARR_PASSWORD']) ? 'SET' : 'NOT SET') . "<br>";

echo "<h3>Step 6: Test with env.php include</h3>";
require_once 'app/config/env.php';
echo "After including env.php:<br>";
echo "DOLIBARR_API_URL: " . (getenv('DOLIBARR_API_URL') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_API_KEY: " . (getenv('DOLIBARR_API_KEY') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_USERNAME: " . (getenv('DOLIBARR_USERNAME') ?: 'NOT SET') . "<br>";
echo "DOLIBARR_PASSWORD: " . (getenv('DOLIBARR_PASSWORD') ? 'SET' : 'NOT SET') . "<br>";

echo "<h3>Step 7: Test DolibarrService</h3>";
try {
    require_once 'app/services/DolibarrService.php';
    $dolibarr = new DolibarrService();
    echo "DolibarrService created successfully<br>";
} catch (Exception $e) {
    echo "Error creating DolibarrService: " . $e->getMessage() . "<br>";
}
?>