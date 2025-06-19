<?php
require_once 'app/config/database.php';

class Ticket {
    private $conn;
    private $table = 'llx_ticket';
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function createTicket($data) {
        try {
            // Generate a reference number for the ticket
            $ticketRef = 'TICKET' . date('YmdHis');
            
            // Generate a unique track_id
            $trackId = 'TK' . date('YmdHis') . rand(1000, 9999);
            
            // Insert into tickets table
            $sql = "INSERT INTO " . $this->table . " (ref, track_id, fk_soc, fk_user_create, subject, message, type_code, category_code, severity_code, datec, email, status)
                    VALUES (?, ?, 0, 0, ?, ?, ?, ?, ?, NOW(), ?, 0)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                $ticketRef,
                $trackId,
                $data['subject'],
                $data['message'],
                $data['type_code'],
                $data['category_code'],
                $data['severity_code'],
                $data['email']
            ]);
            
            return $ticketRef;
        } catch (PDOException $e) {
            error_log("Error creating ticket: " . $e->getMessage());
            return false;
        }
    }
    
    public function addAttachment($ticketRef, $file) {
        try {
            $uploadDir = 'uploads/tickets/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = basename($file['name']);
            $uploadFile = $uploadDir . $ticketRef . '_' . $fileName;
            
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                // Get the ticket ID
                $sql = "SELECT rowid FROM " . $this->table . " WHERE ref = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$ticketRef]);
                $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($ticket) {
                    // Insert file reference into database
                    $filesSql = "INSERT INTO llx_ecm_files (label, filepath, filename, src_object_type, src_object_id, datec)
                                VALUES (?, ?, ?, 'ticket', ?, NOW())";
                    $filesStmt = $this->conn->prepare($filesSql);
                    $filesStmt->execute([
                        $fileName,
                        $uploadDir,
                        $fileName,
                        $ticket['rowid']
                    ]);
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error adding attachment: " . $e->getMessage());
            return false;
        }
    }
}