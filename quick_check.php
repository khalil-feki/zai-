<?php
// Quick syntax and basic functionality check
echo "Starting quick check...\n";

// Check if basic files exist
$files = ['index.php', 'app/config/database.php', '.env'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ $file exists\n";
    } else {
        echo "✗ $file missing\n";
    }
}

// Test .env loading
if (file_exists('.env')) {
    $content = file_get_contents('.env');
    if (strpos($content, 'DOLIBARR_API_KEY') !== false) {
        echo "✓ .env has Dolibarr config\n";
    } else {
        echo "✗ .env missing Dolibarr config\n";
    }
}

echo "Quick check completed.\n";
?>