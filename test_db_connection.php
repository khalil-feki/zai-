<?php
try {
    $pdo = new PDO(
        "mysql:host=c137d.myd.infomaniak.com;dbname=c137d_app_dolibarr_20;charset=utf8",
        "c137d_ecom",
        "Ecom2024@",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
    );
    echo "✓ Remote database connection successful!";
} catch(PDOException $e) {
    echo "✗ Connection failed: " . $e->getMessage();
}
?>