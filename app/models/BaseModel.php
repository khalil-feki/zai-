<?php
require_once 'app/config/database.php';

class BaseModel {
    protected $conn;
    protected $table;
    
    public function __construct() {
        // Use the actual database connection instead of FileDatabase
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function findById($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE rowid = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Return the first record or false if none found
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("findById error: " . $e->getMessage());
            return false;
        }
    }
    
    public function findAll() {
        try {
            $query = "SELECT * FROM {$this->table}";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("findAll error: " . $e->getMessage());
            return [];
        }
    }
    
    public function tableExists() {
        try {
            $stmt = $this->conn->query("SHOW TABLES LIKE '{$this->table}'");
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("tableExists error: " . $e->getMessage());
            return false;
        }
    }
}
?>