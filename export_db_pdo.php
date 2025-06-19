<?php
// Database connection details
$db_host = "c137d.myd.infomaniak.com";
$db_name = "c137d_app_dolibarr_20";
$db_user = "c137d_ecom";
$db_pass = "Ecom2024@";
$db_port = 3306;

// Output file - use Windows temp directory to avoid permission issues
$temp_dir = sys_get_temp_dir();
$backup_file = $temp_dir . '\\dolibarr_backup_' . date('Y-m-d_H-i-s') . '.sql';
$download_filename = 'base_data.sql';

try {
    // Connect to the database
    $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Get all tables
    $tables = [];
    $result = $pdo->query("SHOW TABLES");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    
    // Open file for writing
    $file = fopen($backup_file, 'w');
    if (!$file) {
        throw new Exception("Failed to open file for writing: $backup_file");
    }
    
    // Export header
    fwrite($file, "-- Database export for $db_name\n");
    fwrite($file, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");
    fwrite($file, "SET FOREIGN_KEY_CHECKS=0;\n\n");
    
    // Process each table
    foreach ($tables as $table) {
        // Get create table statement
        $stmt = $pdo->query("SHOW CREATE TABLE `$table`");
        $row = $stmt->fetch(PDO::FETCH_NUM);
        fwrite($file, "-- Table structure for table `$table`\n");
        fwrite($file, "DROP TABLE IF EXISTS `$table`;\n");
        fwrite($file, $row[1] . ";\n\n");
        
        // Get table data
        $result = $pdo->query("SELECT * FROM `$table`");
        $numFields = $result->columnCount();
        
        if ($numFields > 0) {
            fwrite($file, "-- Data for table `$table`\n");
            
            $rows = $result->fetchAll(PDO::FETCH_NUM);
            if (count($rows) > 0) {
                $fields = [];
                for ($i = 0; $i < $numFields; $i++) {
                    $meta = $result->getColumnMeta($i);
                    $fields[] = "`" . $meta['name'] . "`";
                }
                
                fwrite($file, "INSERT INTO `$table` (" . implode(", ", $fields) . ") VALUES\n");
                
                $first = true;
                foreach ($rows as $row) {
                    if (!$first) {
                        fwrite($file, ",\n");
                    } else {
                        $first = false;
                    }
                    
                    $values = [];
                    foreach ($row as $value) {
                        if ($value === null) {
                            $values[] = "NULL";
                        } else {
                            $values[] = "'" . addslashes($value) . "'";
                        }
                    }
                    
                    fwrite($file, "(" . implode(", ", $values) . ")");
                }
                fwrite($file, ";\n");
            }
        }
        
        fwrite($file, "\n\n");
    }
    
    fwrite($file, "SET FOREIGN_KEY_CHECKS=1;\n");
    fclose($file);
    
    // Offer the file for download instead of saving it locally
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $download_filename);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file));
    ob_clean();
    flush();
    readfile($backup_file);
    
    // Delete the temporary file after download
    unlink($backup_file);
    exit;
    
} catch (Exception $e) {
    echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>
        <h3>Database Export Failed</h3>
        <p>Error: " . $e->getMessage() . "</p>
        <p>Try these solutions:</p>
        <ul>
            <li>Make sure PHP has write permissions to the system temp directory</li>
            <li>Check if your PHP has enough memory to handle the database export</li>
            <li>Try exporting a smaller subset of tables first</li>
        </ul>
        <p><a href='dolibarr_status.php'>Return to Status Page</a></p>
    </div>";
}
?>