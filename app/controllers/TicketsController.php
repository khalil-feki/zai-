<?php
require_once 'app/models/Ticket.php';

class TicketsController {
    private $ticketModel;
    
    public function __construct() {
        $this->ticketModel = new Ticket();
    }
    
    public function index() {
        // Display the tickets form
        require_once 'app/views/ticket/tickets.php';
    }
    
    public function submit() {
        // Process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ticket'])) {
            // Get form data
            $email = $_POST['email'] ?? '';
            $requestType = $_POST['request_type'] ?? '';
            $ticketGroup = $_POST['ticket_group'] ?? '';
            $severity = $_POST['severity'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $messageContent = $_POST['message'] ?? '';
            
            // Validate form data
            if (empty($email) || empty($subject) || empty($messageContent)) {
                // Return error
                return [
                    'success' => false,
                    'message' => 'Please fill in all required fields.'
                ];
            }
            
            // Create ticket
            $result = $this->ticketModel->createTicket([
                'email' => $email,
                'type_code' => $requestType,
                'category_code' => $ticketGroup,
                'severity_code' => $severity,
                'subject' => $subject,
                'message' => $messageContent
            ]);
            
            // Handle file upload
            if ($result && isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $this->ticketModel->addAttachment($result, $_FILES['attachment']);
            }
            
            return [
                'success' => (bool)$result,
                'message' => $result ? 'Your ticket has been submitted successfully. Reference: ' . $result : 'Failed to submit ticket.'
            ];
        }
        
        return null;
    }
}