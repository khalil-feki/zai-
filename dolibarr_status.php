<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

// Create Dolibarr service
$dolibarr = new DolibarrService();

// Check if export action is requested
if (isset($_GET['export']) && $_GET['export'] === 'true') {
    // Database connection details - use direct values instead of getenv()
    $db_host = "c137d.myd.infomaniak.com";
    $db_name = "c137d_app_dolibarr_20";
    $db_user = "c137d_ecom";
    $db_pass = "Ecom2024@";
    
    // Create backup file
    $backup_file = 'c:/xampp/htdocs/zai/base_data.sql';
    
    // Check if mysqldump exists
    $mysqldump_path = "C:\\xampp\\mysql\\bin\\mysqldump.exe";
    if (!file_exists($mysqldump_path)) {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>
            <h3>Database Export Failed</h3>
            <p>mysqldump executable not found at: {$mysqldump_path}</p>
            <p>Please check your XAMPP installation.</p>
            <p><a href='dolibarr_status.php'>Return to Status Page</a></p>
        </div>";
        exit;
    }
    
    // Command for mysqldump (Windows compatible with proper escaping)
    $command = "\"{$mysqldump_path}\" --host=\"{$db_host}\" --user=\"{$db_user}\" --password=\"{$db_pass}\" --port=3306 --default-character-set=utf8 --skip-opt --add-drop-table --add-locks --create-options --disable-keys --extended-insert --single-transaction --quick \"{$db_name}\" > \"{$backup_file}\" 2>&1";
    
    // Execute the command and capture output
    $output = [];
    exec($command, $output, $return_var);
    
    if ($return_var === 0) {
        echo "<div style='background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>
            <h3>Database Export Successful</h3>
            <p>The database has been exported to: {$backup_file}</p>
            <p><a href='dolibarr_status.php'>Return to Status Page</a></p>
        </div>";
        exit;
    } else {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>
            <h3>Database Export Failed</h3>
            <p>Error code: {$return_var}</p>
            <p>Error output: " . implode("<br>", $output) . "</p>
            <p>Command used: " . htmlspecialchars($command) . "</p>
            <p>Please check your database credentials and ensure mysqldump is available.</p>
            <p><a href='dolibarr_status.php'>Return to Status Page</a></p>
        </div>";
        exit;
    }
}

// Output configuration
echo "<h2>Dolibarr Connection Status</h2>";
echo "<h3>Configuration</h3>";
echo "API URL: " . getenv('DOLIBARR_API_URL') . "<br>";
echo "API Key: " . (getenv('DOLIBARR_API_KEY') ? "Set (value hidden)" : "Not set") . "<br>";
echo "Username: " . getenv('DOLIBARR_USERNAME') . "<br>";
echo "Password: " . (getenv('DOLIBARR_PASSWORD') ? "Set (value hidden)" : "Not set") . "<br>";

// Check connection
echo "<h3>Connection Test</h3>";
$isConnected = $dolibarr->isConnected();
echo "Connection Status: " . ($isConnected ? 
    "<span style='color:green;font-weight:bold;'>Connected</span>" : 
    "<span style='color:red;font-weight:bold;'>Not Connected</span>") . "<br><br>";

if ($isConnected) {
    // Try to get products
    echo "<h3>Products Test</h3>";
    echo "Attempting to get products from Dolibarr...<br>";
    $products = $dolibarr->getProducts(5, 0);
    
    if (isset($products['error'])) {
        echo "<span style='color:red;'>Error: " . $products['error'] . "</span><br>";
        if (isset($products['message'])) {
            echo "<span style='color:red;'>Message: " . $products['message'] . "</span><br>";
        }
        
        // Add more debugging for API calls
        echo "<h3>API Call Debugging</h3>";
        echo "Let's try a simple API call to check if the API is working...<br>";
        $url = getenv('DOLIBARR_API_URL') . '/api/index.php/status';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['DOLAPIKEY: ' . getenv('DOLIBARR_API_KEY')],
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        echo "API Status Call HTTP Code: " . $httpCode . "<br>";
        echo "API Status Response: <pre>" . htmlspecialchars($response) . "</pre>";
    } else {
        echo "<span style='color:green;'>Successfully retrieved " . count($products) . " products</span><br>";
        echo "<pre>";
        print_r($products);
        echo "</pre>";
    }
    
    // Add export database button
    echo "<h3>Database Export</h3>";
    echo "<p>Export the Dolibarr database to a SQL file:</p>";
    echo "<a href='dolibarr_status.php?export=true' class='button' style='display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Export Database</a>";
}

// Provide troubleshooting tips
echo "<h3>Troubleshooting Tips</h3>";
echo "<ul>";
echo "<li>Make sure your Dolibarr API URL is correct (should end without a trailing slash)</li>";
echo "<li>Verify your API key is correct and active in Dolibarr</li>";
echo "<li>Check that the API module is enabled in Dolibarr</li>";
echo "<li>Ensure your user has proper permissions to access products</li>";
echo "<li>Try accessing the API directly in your browser: " . getenv('DOLIBARR_API_URL') . "/api/index.php/status</li>";
echo "</ul>";
?>