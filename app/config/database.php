<?php
class Database {
    private $host = "c137d.myd.infomaniak.com";  // Company's database host
    private $db_name = "c137d_app_dolibarr_20";  // Company's database name
    private $username = "c137d_ecom";  // Replace with provided username
    private $password = "Ecom2024@";  // Replace with provided password
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                )
            );
        } catch(PDOException $exception) {
            // Log the error
            error_log("Database connection failed: " . $exception->getMessage());
            
            // In development, show the error
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                echo "Connection failed: " . $exception->getMessage();
            } else {
                // In production, show a user-friendly message
                echo "Database connection error. Please try again later.";
            }
            exit;
        }
        
        return $this->conn;
    }
}?>
