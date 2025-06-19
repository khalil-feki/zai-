<?php
class DolibarrIntegration {
    private $db;
    
    public function __construct() {
        require_once 'app/config/database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Synchronize a user with Dolibarr
     * @param array $userData User data to synchronize
     * @return int|bool User ID if successful, false otherwise
     */
    public function syncUser($userData) {
        try {
            // Check if user exists in Dolibarr
            $query = "SELECT rowid FROM h8pd_societe WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $userData['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // User exists, update their information
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $userId = $user['rowid'];
                
                // Update user data
                $this->updateDolibarrUser($userId, $userData);
                return $userId;
            } else {
                // User doesn't exist, create a new one
                $user = new User();
                return $user->register($userData);
            }
        } catch (Exception $e) {
            error_log("Dolibarr sync error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update a user in Dolibarr
     * @param int $userId User ID to update
     * @param array $userData User data to update
     * @return bool True if successful, false otherwise
     */
    private function updateDolibarrUser($userId, $userData) {
        try {
            $name = $userData['firstname'] . ' ' . ($userData['lastname'] ?? '');
            
            $query = "UPDATE h8pd_societe SET 
                      nom = :nom,
                      firstname = :firstname,
                      lastname = :lastname,
                      address = :address,
                      zip = :zip,
                      town = :town,
                      phone = :phone,
                      phone_mobile = :mobile,
                      tms = NOW()
                      WHERE rowid = :user_id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nom', $name);
            $stmt->bindValue(':firstname', $userData['firstname']);
            $stmt->bindValue(':lastname', $userData['lastname'] ?? '');
            $stmt->bindValue(':address', $userData['address'] ?? null);
            $stmt->bindValue(':zip', $userData['zip'] ?? null);
            $stmt->bindValue(':town', $userData['town'] ?? null);
            $stmt->bindValue(':phone', $userData['phone'] ?? null);
            $stmt->bindValue(':mobile', $userData['mobile'] ?? null);
            $stmt->bindValue(':user_id', $userId);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Dolibarr update error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get customer categories from Dolibarr
     * @return array List of customer categories
     */
    public function getCustomerCategories() {
        try {
            $query = "SELECT rowid, label FROM h8pd_categorie WHERE type = 2 ORDER BY label"; // Type 2 is for customers
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting customer categories: " . $e->getMessage());
            return [];
        }
    }
}
?>