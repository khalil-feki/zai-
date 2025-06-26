<?php
/**
 * Comprehensive Project Scan
 * This script identifies and reports all major issues in the ZAI E-commerce project
 */

echo "<h1>ZAI E-commerce Project - Comprehensive Scan Report</h1>";
echo "<style>
    .success { color: green; background: #e8f5e8; padding: 10px; margin: 5px 0; }
    .warning { color: orange; background: #fff3cd; padding: 10px; margin: 5px 0; }
    .error { color: red; background: #f8d7da; padding: 10px; margin: 5px 0; }
    .info { color: blue; background: #d1ecf1; padding: 10px; margin: 5px 0; }
    h2 { border-bottom: 2px solid #333; }
</style>";

$issues = [];
$warnings = [];
$successes = [];

echo "<h2>1. Environment Configuration Check</h2>";

// Check .env file
if (file_exists('.env')) {
    echo "<div class='success'>✓ .env file exists</div>";
    $envContent = file_get_contents('.env');
    if (strpos($envContent, 'DOLIBARR_API_KEY') !== false) {
        echo "<div class='success'>✓ Dolibarr API configuration found</div>";
    } else {
        $issues[] = ".env file missing Dolibarr API configuration";
        echo "<div class='error'>✗ .env file missing Dolibarr API configuration</div>";
    }
} else {
    $issues[] = ".env file not found";
    echo "<div class='error'>✗ .env file not found</div>";
}

// Check if env.php is loading correctly
require_once 'app/config/env.php';
if (function_exists('env')) {
    echo "<div class='success'>✓ Environment loader function available</div>";
} else {
    $issues[] = "Environment loader function not available";
    echo "<div class='error'>✗ Environment loader function not available</div>";
}

echo "<h2>2. Database Connection Check</h2>";

try {
    require_once 'app/config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
    if ($conn) {
        echo "<div class='success'>✓ Database connection successful</div>";
        
        // Check critical tables
        $tables = ['h8pd_societe', 'h8pd_commande', 'h8pd_commandedet', 'h8pd_product', 'h8pd_cart'];
        foreach ($tables as $table) {
            $stmt = $conn->prepare("SHOW TABLES LIKE ?");
            $stmt->execute([$table]);
            if ($stmt->rowCount() > 0) {
                echo "<div class='success'>✓ Table $table exists</div>";
            } else {
                $issues[] = "Missing critical table: $table";
                echo "<div class='error'>✗ Missing critical table: $table</div>";
            }
        }
    } else {
        $issues[] = "Database connection failed";
        echo "<div class='error'>✗ Database connection failed</div>";
    }
} catch (Exception $e) {
    $issues[] = "Database error: " . $e->getMessage();
    echo "<div class='error'>✗ Database error: " . $e->getMessage() . "</div>";
}

echo "<h2>3. Dolibarr API Connection Check</h2>";

try {
    require_once 'app/services/DolibarrService.php';
    $dolibarr = new DolibarrService();
    
    // Test authentication
    if ($dolibarr->authenticate()) {
        echo "<div class='success'>✓ Dolibarr API authentication successful</div>";
    } else {
        $issues[] = "Dolibarr API authentication failed";
        echo "<div class='error'>✗ Dolibarr API authentication failed</div>";
    }
} catch (Exception $e) {
    $issues[] = "Dolibarr service error: " . $e->getMessage();
    echo "<div class='error'>✗ Dolibarr service error: " . $e->getMessage() . "</div>";
}

echo "<h2>4. File Structure Check</h2>";

$requiredFiles = [
    'index.php',
    'app/config/config.php',
    'app/config/database.php',
    'app/config/env.php',
    'app/models/User.php',
    'app/models/Order.php',
    'app/models/Product.php',
    'app/models/Cart.php',
    'app/controllers/AuthController.php',
    'app/controllers/CheckoutController.php',
    'app/services/DolibarrService.php',
    'app/helpers/functions.php'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "<div class='success'>✓ $file exists</div>";
    } else {
        $issues[] = "Missing required file: $file";
        echo "<div class='error'>✗ Missing required file: $file</div>";
    }
}

echo "<h2>5. Directory Permissions Check</h2>";

$requiredDirs = [
    'public/uploads/products',
    'public/img/products',
    'cache',
    'cache/dolibarr'
];

foreach ($requiredDirs as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "<div class='warning'>⚠ Created missing directory: $dir</div>";
        } else {
            $issues[] = "Cannot create directory: $dir";
            echo "<div class='error'>✗ Cannot create directory: $dir</div>";
        }
    } else {
        if (is_writable($dir)) {
            echo "<div class='success'>✓ Directory $dir is writable</div>";
        } else {
            $warnings[] = "Directory $dir is not writable";
            echo "<div class='warning'>⚠ Directory $dir is not writable</div>";
        }
    }
}

echo "<h2>6. PHP Configuration Check</h2>";

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
    echo "<div class='success'>✓ PHP version " . PHP_VERSION . " is compatible</div>";
} else {
    $warnings[] = "PHP version " . PHP_VERSION . " may have compatibility issues";
    echo "<div class='warning'>⚠ PHP version " . PHP_VERSION . " may have compatibility issues</div>";
}

// Check required extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'curl', 'json', 'mbstring'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<div class='success'>✓ PHP extension $ext is loaded</div>";
    } else {
        $issues[] = "Missing PHP extension: $ext";
        echo "<div class='error'>✗ Missing PHP extension: $ext</div>";
    }
}

echo "<h2>7. Error Log Analysis</h2>";

if (file_exists('php_errors.log')) {
    $errorLog = file_get_contents('php_errors.log');
    $lines = explode("\n", $errorLog);
    $recentErrors = array_slice(array_filter($lines), -10); // Last 10 non-empty lines
    
    echo "<div class='info'>Recent error log entries:</div>";
    echo "<pre style='background: #f8f9fa; padding: 10px; border: 1px solid #ddd;'>";
    foreach ($recentErrors as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
    
    // Check for specific error patterns
    if (strpos($errorLog, 'ENV file not found') !== false) {
        $issues[] = "Environment file loading issues detected in logs";
        echo "<div class='error'>✗ Environment file loading issues detected in logs</div>";
    }
    
    if (strpos($errorLog, 'Unauthorized') !== false) {
        $issues[] = "Dolibarr API authorization issues detected in logs";
        echo "<div class='error'>✗ Dolibarr API authorization issues detected in logs</div>";
    }
    
    if (strpos($errorLog, 'Duplicate entry') !== false) {
        $warnings[] = "Database duplicate entry issues detected in logs";
        echo "<div class='warning'>⚠ Database duplicate entry issues detected in logs</div>";
    }
} else {
    echo "<div class='info'>No error log file found</div>";
}

echo "<h2>8. Summary Report</h2>";

echo "<div class='info'><h3>Critical Issues Found: " . count($issues) . "</h3>";
if (!empty($issues)) {
    echo "<ul>";
    foreach ($issues as $issue) {
        echo "<li>" . htmlspecialchars($issue) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No critical issues found!</p>";
}
echo "</div>";

echo "<div class='warning'><h3>Warnings Found: " . count($warnings) . "</h3>";
if (!empty($warnings)) {
    echo "<ul>";
    foreach ($warnings as $warning) {
        echo "<li>" . htmlspecialchars($warning) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No warnings found!</p>";
}
echo "</div>";

echo "<h2>9. Recommended Actions</h2>";

echo "<div class='info'>";
echo "<h3>Immediate Actions Required:</h3>";
echo "<ol>";
echo "<li><strong>Fix Environment Loading:</strong> The .env file exists but may not be loading correctly. Check the path in env.php.</li>";
echo "<li><strong>Dolibarr API Authentication:</strong> Verify API key and credentials in .env file.</li>";
echo "<li><strong>Database Issues:</strong> Check for duplicate entry constraints and missing tables.</li>";
echo "<li><strong>File Permissions:</strong> Ensure upload directories are writable.</li>";
echo "</ol>";

echo "<h3>Performance Optimizations:</h3>";
echo "<ol>";
echo "<li>Implement proper error handling in all controllers</li>";
echo "<li>Add input validation and sanitization</li>";
echo "<li>Optimize database queries with proper indexing</li>";
echo "<li>Implement caching for Dolibarr API responses</li>";
echo "</ol>";

echo "<h3>Security Improvements:</h3>";
echo "<ol>";
echo "<li>Move .env file outside web root</li>";
echo "<li>Implement CSRF protection</li>";
echo "<li>Add rate limiting for API calls</li>";
echo "<li>Sanitize all user inputs</li>";
echo "</ol>";
echo "</div>";

echo "<hr>";
echo "<p><small>Scan completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>