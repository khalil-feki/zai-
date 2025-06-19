<?php
require_once 'app/config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // The exact query from Order.php
    $query = "INSERT INTO h8pd_commande (
        ref, entity, fk_soc, date_creation, date_commande, fk_user_author,
        fk_statut, amount_ht, total_tva, total_ttc,
        note_private, model_pdf, fk_cond_reglement,
        fk_multicurrency, multicurrency_code, multicurrency_tx,
        multicurrency_total_ht, multicurrency_total_tva, multicurrency_total_ttc
    ) VALUES (
        :ref, 1, :societe_id, NOW(), CURDATE(), :user_id,
        1, :amount_ht, :total_tva, :total_ttc,
        :user_email, 'eratosthene', 12,
        NULL, 'TND', 1.00000000,
        :multicurrency_total_ht, :multicurrency_total_tva, :multicurrency_total_ttc
    )";
    
    echo "SQL Query:\n";
    echo $query . "\n\n";
    
    // Count placeholders
    preg_match_all('/:([a-zA-Z_][a-zA-Z0-9_]*)/', $query, $matches);
    $placeholders = $matches[1];
    
    echo "Found placeholders (" . count($placeholders) . "):\n";
    foreach ($placeholders as $i => $placeholder) {
        echo ($i + 1) . ". :$placeholder\n";
    }
    
    echo "\nParameters being bound:\n";
    $params = [
        'ref' => 'TEST-REF',
        'societe_id' => 1,
        'user_id' => 1,
        'amount_ht' => 10.00,
        'total_tva' => 1.95,
        'total_ttc' => 11.95,
        'multicurrency_total_ht' => 10.00,
        'multicurrency_total_tva' => 1.95,
        'multicurrency_total_ttc' => 11.95,
        'user_email' => 'test@example.com'
    ];
    
    $i = 1;
    foreach ($params as $key => $value) {
        echo "$i. :$key = $value\n";
        $i++;
    }
    
    echo "\nMismatch check:\n";
    $boundParams = array_keys($params);
    $missingInBound = array_diff($placeholders, $boundParams);
    $extraInBound = array_diff($boundParams, $placeholders);
    
    if (!empty($missingInBound)) {
        echo "ERROR: Placeholders not bound: " . implode(', ', $missingInBound) . "\n";
    }
    
    if (!empty($extraInBound)) {
        echo "ERROR: Extra parameters bound: " . implode(', ', $extraInBound) . "\n";
    }
    
    if (empty($missingInBound) && empty($extraInBound)) {
        echo "SUCCESS: All placeholders match bound parameters\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
?>