<?php
require_once 'app/config/env.php';
require_once 'app/services/DolibarrService.php';

// Create Dolibarr service
$dolibarr = new DolibarrService();

// Try to authenticate
echo "Attempting to authenticate with Dolibarr...<br>";
$auth = $dolibarr->authenticate();
echo "Authentication result: " . ($auth ? "Success" : "Failed") . "<br><br>";

// Try to get products
echo "Attempting to get products from Dolibarr...<br>";
$products = $dolibarr->getProducts(10, 0);

if (isset($products['error'])) {
    echo "Error: " . $products['error'] . "<br>";
    if (isset($products['message'])) {
        echo "Message: " . $products['message'] . "<br>";
    }
} else {
    echo "Successfully retrieved " . count($products) . " products:<br><pre>";
    print_r($products);
    echo "</pre>";
}
?>