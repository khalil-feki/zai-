<?php
require_once 'app/config/database.php';
require_once 'app/services/DolibarrService.php';
require_once 'app/models/Order.php';

// Initialize services
$dolibarrService = new DolibarrService();
$orderModel = new Order();

// Handle form submission
if ($_POST && isset($_POST['create_order'])) {
    try {
        // Get form data
        $clientName = $_POST['client_name'] ?? '';
        $clientEmail = $_POST['client_email'] ?? '';
        $deliveryDate = $_POST['delivery_date'] ?? '';
        $paymentTerms = $_POST['payment_terms'] ?? '';
        $paymentMode = $_POST['payment_mode'] ?? '';
        $publicNote = $_POST['public_note'] ?? '';
        
        // Validate required fields
        if (empty($clientName) || empty($publicNote)) {
            throw new Exception('Veuillez remplir tous les champs obligatoires');
        }
        
        // Default product values since we're using public note for product info
        $productName = 'Produit standard';
        $quantity = 1;
        $unitPrice = 0.00;
        
        // Find or create customer in Dolibarr
        // Gestion sécurisée du client
        $customer = null;
        $customerId = 1; // Default customer ID
        if (!empty($clientEmail)) {
            $customerResponse = $dolibarrService->getCustomerByEmail($clientEmail);
            if ($customerResponse && !empty($customerResponse) && isset($customerResponse[0])) {
                $customer = $customerResponse[0];
                $customerId = $customer['id'] ?? 1;
            }
        }
        
        // Données corrigées pour Dolibarr
        $orderData = [
            'socid' => $customerId,  // Use 'socid' instead of 'customer_id' for Dolibarr API
            'date' => time(),
            'delivery_date' => !empty($deliveryDate) ? strtotime($deliveryDate) : null,
            'note_public' => $publicNote,
            'lines' => [
                [
                    'fk_product' => 1, // Use 'fk_product' for Dolibarr API
                    'qty' => $quantity, // Use 'qty' for Dolibarr API
                    'subprice' => $unitPrice, // Use 'subprice' for Dolibarr API
                    'desc' => $productName
                ]
            ]
        ];
        
        // Create draft order in Dolibarr
        $dolibarrOrder = $dolibarrService->createDraftOrder($orderData);
        
        if (isset($dolibarrOrder['error'])) {
            $errorMessage = "Erreur lors de la création de la commande dans Dolibarr: " . $dolibarrOrder['error'];
            if (isset($dolibarrOrder['message'])) {
                $errorMessage .= " - Détails: " . $dolibarrOrder['message'];
            }
        } elseif ($dolibarrOrder && (isset($dolibarrOrder['id']) || isset($dolibarrOrder['rowid']))) {
            // Create local order with proper item structure
            $localOrderItems = [
                [
                    'product_id' => 1, // Default product ID
                    'quantity' => 1,   // Default quantity
                    'price' => 10.00,  // Default price
                    'total_price' => 10.00 // Total for this item
                ]
            ];
            
            $dolibarrId = isset($dolibarrOrder['id']) ? $dolibarrOrder['id'] : (isset($dolibarrOrder['rowid']) ? $dolibarrOrder['rowid'] : null);
            $localOrderId = $orderModel->createOrder(1, $localOrderItems, $dolibarrId);
            
            if ($localOrderId) {
                $dolibarrId = isset($dolibarrOrder['id']) ? $dolibarrOrder['id'] : (isset($dolibarrOrder['rowid']) ? $dolibarrOrder['rowid'] : 'N/A');
                $successMessage = "Commande créée avec succès! ID Local: {$localOrderId}, ID Dolibarr: {$dolibarrId}";
            } else {
                $errorMessage = "Erreur lors de la création de la commande locale";
            }
        } else {
            $errorMessage = "Erreur lors de la création de la commande dans Dolibarr";
        }
        
    } catch (Exception $e) {
        $errorMessage = "Erreur: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-header {
            background: linear-gradient(135deg, #4a6cf7, #6a30a3);
            color: white;
            padding: 20px;
            margin: -30px -30px 30px -30px;
            border-radius: 8px 8px 0 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
        .btn {
            background: linear-gradient(135deg, #4a6cf7, #6a30a3);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .required {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Créer Commande</h1>
            <p>Réf. Brouillon - Nouveau</p>
        </div>
        
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="client_name">Client <span class="required">*</span></label>
                <input type="text" id="client_name" name="client_name" placeholder="Nom du client" required>
            </div>
            
            <div class="form-group">
                <label for="client_email">Email Client</label>
                <input type="email" id="client_email" name="client_email" placeholder="email@exemple.com">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="order_date">Date</label>
                    <input type="date" id="order_date" name="order_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="delivery_date">Date prévue de livraison</label>
                    <input type="date" id="delivery_date" name="delivery_date">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="payment_terms">Conditions de règlement</label>
                    <select id="payment_terms" name="payment_terms">
                        <option value="">Sélectionner...</option>
                        <option value="RECEP">A réception de facture</option>
                        <option value="30D">30 jours</option>
                        <option value="60D">60 jours</option>
                        <option value="30DENDMONTH">30 jours fin de mois</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="payment_mode">Mode de règlement</label>
                    <select id="payment_mode" name="payment_mode">
                        <option value="">Sélectionner...</option>
                        <option value="CHQ">Chèque</option>
                        <option value="VIR">Virement</option>
                        <option value="CB">Carte Bancaire</option>
                        <option value="LIQ">Espèces</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="public_note">Note (publique) <span class="required">*</span></label>
                <textarea id="public_note" name="public_note" placeholder="Veuillez indiquer le nom du produit et la quantité..." required></textarea>
                <small style="color: #666; font-style: italic;">Exemple: Produit ABC - Quantité: 5</small>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <button type="submit" name="create_order" class="btn">Créer la Commande</button>
            </div>
        </form>
    </div>
    
    <script>
        // Focus on public note field for product information
        document.addEventListener('DOMContentLoaded', function() {
            const publicNoteField = document.getElementById('public_note');
            publicNoteField.addEventListener('input', function() {
                console.log('Note publique mise à jour:', this.value);
            });
        });
    </script>
</body>
</html>