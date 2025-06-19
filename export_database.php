<?php
require_once 'app/config/env.php';

// Set page title and add some basic styling
echo "<!DOCTYPE html>
<html>
<head>
    <title>Dolibarr Database Export</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .info { background-color: #d1ecf1; color: #0c5460; }
        h1, h2 { color: #333; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; 
               text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn:hover { background-color: #45a049; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Dolibarr Database Export</h1>";

// Check if export action is requested
if (isset($_GET['export']) && $_GET['export'] === 'true') {
    // Database connection details from environment variables
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASSWORD');
    
    // Create backup file
    $backup_file = 'c:/xampp/htdocs/zai/base_data.sql';
    
    // Command for mysqldump (Windows compatible)
    $command = "\"C:\\xampp\\mysql\\bin\\mysqldump\" --host={$db_host} --user={$db_user} --password={$db_pass} {$db_name} > {$backup_file}";
    
    // Execute the command
    exec($command, $output, $return_var);
    
    if ($return_var === 0) {
        echo "<div class='card success'>
            <h2>Database Export Successful</h2>
            <p>The database has been exported to: {$backup_file}</p>
            <p>File size: " . round(filesize($backup_file) / (1024 * 1024), 2) . " MB</p>
            <p><a href='export_database.php' class='btn'>Return to Export Page</a></p>
        </div>";
    } else {
        echo "<div class='card error'>
            <h2>Database Export Failed</h2>
            <p>Error code: {$return_var}</p>
            <p>Please check your database credentials and ensure mysqldump is available.</p>
            <p><a href='export_database.php' class='btn'>Try Again</a></p>
        </div>";
    }
} else {
    // Display database information and export button
    echo "<div class='card info'>
        <h2>Database Information</h2>
        <p><strong>Host:</strong> " . getenv('DB_HOST') . "</p>
        <p><strong>Database:</strong> " . getenv('DB_NAME') . "</p>
        <p><strong>User:</strong> " . getenv('DB_USER') . "</p>
        <p>Click the button below to export the entire Dolibarr database to a SQL file.</p>
        <p>This process may take a few minutes depending on the size of your database.</p>
        <a href='export_database.php?export=true' class='btn'>Export Database</a>
    </div>";
}

echo "</div></body></html>";
?>