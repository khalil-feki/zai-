<?php
require_once 'app/config/database.php';
require_once 'BaseModel.php';

class User extends BaseModel {
    protected $table = 'h8pd_societe';
    protected $extrafieldsTable = 'h8pd_societe_extrafields';
    protected $passwordField = 'mot_de_passe';
    
    public function __construct() {
        parent::__construct();
        error_log("User model initialized with table: {$this->table}");
    }
    
    public function login($email, $password) {
        try {
            error_log("Login attempt for user: {$email}");
            
            // Query user by email
            $query = "SELECT s.*, e.{$this->passwordField} 
                      FROM {$this->table} s
                      LEFT JOIN {$this->extrafieldsTable} e ON s.rowid = e.fk_object
                      WHERE s.email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Check if password field exists in the user record
                if (!isset($user[$this->passwordField]) || empty($user[$this->passwordField])) {
                    error_log("No password set for user: {$email}");
                    return false;
                }
                
                // Check if the password is stored as plain text or MD5 hash
                $storedPassword = $user[$this->passwordField];
                $hashedPassword = md5($password);
                
                // Try both plain text and MD5 comparison
                if ($password === $storedPassword || $hashedPassword === $storedPassword) {
                    error_log("Password verified for user: {$email}");
                    return $user;
                } else {
                    error_log("Password verification failed for user: {$email}");
                    error_log("Input password: " . $password);
                    error_log("Hashed input: " . $hashedPassword);
                    error_log("Stored password: " . $storedPassword);
                }
            } else {
                error_log("No user found with email: {$email}");
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
    
    // Helper method to migrate password from main table to extrafields
    private function migratePasswordToExtrafields($userId, $passwordHash) {
        try {
            // Check if extrafields record exists
            $query = "SELECT rowid FROM {$this->extrafieldsTable} WHERE fk_object = :fk_object";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fk_object', $userId);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // Update existing record
                $query = "UPDATE {$this->extrafieldsTable} 
                          SET {$this->passwordField} = :password 
                          WHERE fk_object = :fk_object";
            } else {
                // Insert new record
                $query = "INSERT INTO {$this->extrafieldsTable} (fk_object, {$this->passwordField}) 
                          VALUES (:fk_object, :password)";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fk_object', $userId);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->execute();
            
            error_log("Password migrated to extrafields for user ID: {$userId}");
        } catch (Exception $e) {
            error_log("Password migration error: " . $e->getMessage());
        }
    }
    
    // Modify the register method to provide more detailed error information
    
    public function register($userData) {
        try {
            // Check if user already exists in h8pd_societe
            $query = "SELECT rowid FROM {$this->table} WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $userData['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                echo "<p style='color:red'>Error: User already exists with email: {$userData['email']}</p>";
                return false;
            }
            
            // Check if user already exists in h8pd_user
            $query = "SELECT rowid FROM h8pd_user WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $userData['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                echo "<p style='color:red'>Error: User already exists in h8pd_user with email: {$userData['email']}</p>";
                return false;
            }
            
            // Start transaction
            $this->conn->beginTransaction();
            
            // Check required fields
            $requiredFields = ['email', 'password'];
            foreach ($requiredFields as $field) {
                if (empty($userData[$field])) {
                    echo "<p style='color:red'>Error: Missing required field: {$field}</p>";
                    return false;
                }
            }
            
            // Prepare name field - use company_name if provided, otherwise use firstname + lastname
            $name = !empty($userData['company_name']) ? $userData['company_name'] : 
                   ($userData['firstname'] ?? '') . ' ' . ($userData['lastname'] ?? '');
            
            // Insert new user into h8pd_societe - using only columns that exist in the table
            $query = "INSERT INTO {$this->table} (nom, email, entity, datec, status) 
                      VALUES (:nom, :email, 1, NOW(), 1)";
            
            // Debug output
            echo "<p>Executing h8pd_societe query: " . str_replace([':nom', ':email'], 
                                                     [$name, $userData['email']], 
                                                     $query) . "</p>";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nom', $name);
            $stmt->bindParam(':email', $userData['email']);
            
            if ($stmt->execute()) {
                $userId = $this->conn->lastInsertId();
                echo "<p style='color:green'>User inserted into h8pd_societe with ID: {$userId}</p>";
                
                // Store password as plain text to match existing pattern
                $password = $userData['password'];
                
                // Insert password into extrafields table
                $query = "INSERT INTO {$this->extrafieldsTable} (fk_object, {$this->passwordField}) 
                          VALUES (:fk_object, :password)";
                
                // Debug output
                echo "<p>Executing extrafields query: " . str_replace([':fk_object', ':password'], 
                                                                   [$userId, $password], 
                                                                   $query) . "</p>";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':fk_object', $userId);
                $stmt->bindParam(':password', $password);
                
                if ($stmt->execute()) {
                    echo "<p style='color:green'>Password stored in extrafields for user ID: {$userId}</p>";
                    
                    // Now insert the same user into h8pd_user table to satisfy foreign key constraints
                    $baseLogin = $userData['username'] ?? strtolower(str_replace(' ', '', $name));
                    
                    // Ensure login uniqueness
                    $login = $baseLogin;
                    $counter = 1;
                    while (true) {
                        $checkQuery = "SELECT COUNT(*) FROM h8pd_user WHERE login = :login";
                        $checkStmt = $this->conn->prepare($checkQuery);
                        $checkStmt->bindParam(':login', $login);
                        $checkStmt->execute();
                        
                        if ($checkStmt->fetchColumn() == 0) {
                            break; // Login is unique
                        }
                        
                        $login = $baseLogin . $counter;
                        $counter++;
                    }
                    
                    $firstname = $userData['firstname'] ?? '';
                    $lastname = $userData['lastname'] ?? '';
                    
                    $userQuery = "INSERT INTO h8pd_user (entity, login, pass_crypted, lastname, firstname, email, admin, fk_soc, statut, datec) 
                                  VALUES (1, :login, :password, :lastname, :firstname, :email, 0, :fk_soc, 1, NOW())";
                    
                    echo "<p>Executing h8pd_user query for user ID: {$userId}</p>";
                    
                    $userStmt = $this->conn->prepare($userQuery);
                    $userStmt->bindParam(':login', $login);
                    $userStmt->bindParam(':password', $password);
                    $userStmt->bindParam(':lastname', $lastname);
                    $userStmt->bindParam(':firstname', $firstname);
                    $userStmt->bindParam(':email', $userData['email']);
                    $userStmt->bindParam(':fk_soc', $userId);
                    
                    if ($userStmt->execute()) {
                        $userTableId = $this->conn->lastInsertId();
                        echo "<p style='color:green'>User also inserted into h8pd_user with ID: {$userTableId}, linked to company ID: {$userId}</p>";
                        
                        $this->conn->commit();
                        echo "<p style='color:green'>Registration complete! User created in both tables with company ID: {$userId} and user ID: {$userTableId}</p>";
                        return $userId;
                    } else {
                        $this->conn->rollBack();
                        $error = $userStmt->errorInfo();
                        echo "<p style='color:red'>Failed to insert user into h8pd_user table. SQL error: " . json_encode($error) . "</p>";
                        return false;
                    }
                } else {
                    $this->conn->rollBack();
                    $error = $stmt->errorInfo();
                    echo "<p style='color:red'>Failed to insert password for user: {$userId}. SQL error: " . json_encode($error) . "</p>";
                    return false;
                }
            } else {
                $this->conn->rollBack();
                $error = $stmt->errorInfo();
                echo "<p style='color:red'>Failed to insert user into h8pd_societe table. SQL error: " . json_encode($error) . "</p>";
                return false;
            }
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            echo "<p style='color:red'>Registration exception: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . "</p>";
            return false;
        }
    }
    
    public function updatePassword($userId, $newPassword) {
        try {
            // Store password as plain text to match existing pattern
            $password = $newPassword;
            
            // Check if extrafields record exists
            $query = "SELECT rowid FROM {$this->extrafieldsTable} WHERE fk_object = :fk_object";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fk_object', $userId);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // Update existing record
                $query = "UPDATE {$this->extrafieldsTable} 
                          SET {$this->passwordField} = :password 
                          WHERE fk_object = :fk_object";
            } else {
                // Insert new record
                $query = "INSERT INTO {$this->extrafieldsTable} (fk_object, {$this->passwordField}) 
                          VALUES (:fk_object, :password)";
            }
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':fk_object', $userId);
            $stmt->bindParam(':password', $password);
            
            if ($stmt->execute()) {
                error_log("Password updated for user ID: {$userId}");
                return true;
            } else {
                error_log("Failed to update password for user ID: {$userId}");
                return false;
            }
        } catch (Exception $e) {
            error_log("Password update error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getUserById($id) {
        try {
            $query = "SELECT s.*, e.{$this->passwordField} 
                      FROM {$this->table} s
                      LEFT JOIN {$this->extrafieldsTable} e ON s.rowid = e.fk_object
                      WHERE s.rowid = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error getting user by ID: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAllUsers($limit = 100) {
        try {
            $query = "SELECT s.*, e.{$this->passwordField} 
                      FROM {$this->table} s
                      LEFT JOIN {$this->extrafieldsTable} e ON s.rowid = e.fk_object
                      WHERE s.email IS NOT NULL
                      ORDER BY s.rowid DESC
                      LIMIT :limit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting all users: " . $e->getMessage());
            return [];
        }
    }
    
    // Add these getter methods to your User class, just before the closing brace
    
    public function getTable() {
        return $this->table;
    }
    
    public function getExtrafieldsTable() {
        return $this->extrafieldsTable;
    }
    
    /**
     * Update user profile information
     * @param int $userId User ID to update
     * @param array $data User data to update
     * @return bool True if successful, false otherwise
     */
    public function updateProfile($userId, $data) {
        try {
            $this->conn->beginTransaction();
            
            // Update user data in main table
            $query = "UPDATE {$this->table} SET 
                      nom = :nom,
                      email = :email,
                      tms = NOW()
                      WHERE rowid = :user_id";
            
            // Prepare name field - use firstname + lastname
            $name = ($data['firstname'] ?? '') . ' ' . ($data['lastname'] ?? '');
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nom', $name);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':user_id', $userId);
            
            $mainTableUpdated = $stmt->execute();
            
            // If password change is requested
            if (!empty($data['new_password'])) {
                // Verify current password
                $user = $this->getUserById($userId);
                
                if (!$user) {
                    $this->conn->rollBack();
                    error_log("User not found for password update: {$userId}");
                    return false;
                }
                
                $storedPassword = $user[$this->passwordField];
                $currentPassword = $data['current_password'];
                $hashedCurrentPassword = md5($currentPassword);
                
                // Verify current password
                if ($currentPassword !== $storedPassword && $hashedCurrentPassword !== $storedPassword) {
                    $this->conn->rollBack();
                    error_log("Current password verification failed for user: {$userId}");
                    return false;
                }
                
                // Update password
                $passwordUpdated = $this->updatePassword($userId, $data['new_password']);
                
                if (!$passwordUpdated) {
                    $this->conn->rollBack();
                    error_log("Failed to update password for user: {$userId}");
                    return false;
                }
            }
            
            $this->conn->commit();
            error_log("Profile updated for user ID: {$userId}");
            return true;
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            error_log("Profile update error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get user addresses
     * @param int $userId User ID to get addresses for
     * @return array Array of user addresses
     */
    public function getUserAddresses($userId) {
        try {
            // Check if there's an address table or if addresses are stored in the main user table
            // For now, we'll return address data from the main user table
            $query = "SELECT rowid, address, zip, town, fk_pays as country_id
                      FROM {$this->table}
                      WHERE rowid = :user_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $address = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Format the address for display
                if (!empty($address['address']) || !empty($address['zip']) || !empty($address['town'])) {
                    return [$address]; // Return as array to support multiple addresses in the future
                }
            }
            
            return []; // Return empty array if no addresses found
        } catch (Exception $e) {
            error_log("Error getting user addresses: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Save user address
     * @param int $userId User ID
     * @param array $data Address data
     * @return bool True if successful, false otherwise
     */
    public function saveAddress($userId, $data) {
        try {
            // Since we're storing address in the main user table for now
            $query = "UPDATE {$this->table} SET 
                      address = :address,
                      zip = :zip,
                      town = :town,
                      fk_pays = :country_id,
                      tms = NOW()
                      WHERE rowid = :user_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':zip', $data['zip']);
            $stmt->bindParam(':town', $data['town']);
            $stmt->bindParam(':country_id', $data['country_id']);
            $stmt->bindParam(':user_id', $userId);
            
            if ($stmt->execute()) {
                error_log("Address saved for user ID: {$userId}");
                return true;
            } else {
                error_log("Failed to save address for user ID: {$userId}");
                return false;
            }
        } catch (Exception $e) {
            error_log("Address save error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get user orders
     * @param int $userId User ID to get orders for
     * @return array Array of user orders
     */
    public function getUserOrders($userId) {
        try {
            // This is a placeholder - you'll need to adjust this to your actual orders table
            $query = "SELECT * FROM h8pd_commande 
                      WHERE fk_soc = :user_id 
                      ORDER BY date_creation DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting user orders: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Find user by email
     * @param string $email User email
     * @return array|false User data or false if not found
     */
    public function findByEmail($email) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error finding user by email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get user by email and token
     * @param string $email User email
     * @param string $token Reset token
     * @return array|false User data or false if not found
     */
    public function getUserByEmailAndToken($email, $token) {
        try {
            $query = "SELECT u.* FROM {$this->table} u
                      JOIN reset_tokens t ON u.rowid = t.user_id
                      WHERE u.email = :email AND t.token = :token
                      AND t.expires > NOW() LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting user by email and token: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Clear reset token
     * @param int $userId User ID
     * @return bool Success or failure
     */
    public function clearResetToken($userId) {
        try {
            $query = "DELETE FROM reset_tokens WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error clearing reset token: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify reset token
     * @param string $email User email
     * @param string $token Reset token
     * @return bool Valid or invalid
     */
    public function verifyResetToken($email, $token) {
        try {
            $query = "SELECT COUNT(*) FROM {$this->table} u
                      JOIN reset_tokens t ON u.rowid = t.user_id
                      WHERE u.email = :email AND t.token = :token
                      AND t.expires > NOW()";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            return (int)$stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            error_log("Error verifying reset token: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get user by email and reset token
     * @param string $email User email
     * @param string $token Reset token
     * @return array|false User data or false if not found
     */
    
    
    /**
     * Save reset token
     * @param int $userId User ID
     * @param string $token Reset token
     * @param string $expires Expiration datetime
     * @return bool Success or failure
     */
    public function saveResetToken($userId, $token, $expires) {
        try {
            // First, clear any existing tokens for this user
            $this->clearResetToken($userId);
            
            // Insert new reset token
            $query = "INSERT INTO reset_tokens (user_id, token, expires) 
                      VALUES (:user_id, :token, :expires)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expires', $expires);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error saving reset token: " . $e->getMessage());
            return false;
        }
    }

} // End of User class
