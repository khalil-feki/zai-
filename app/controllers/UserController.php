<?php
require_once 'app/models/User.php';
require_once 'app/models/Order.php';
require_once 'app/middleware/AuthMiddleware.php';

class UserController {
    private $userModel;
    private $orderModel;
    
    public function __construct() {
        // Check if user is logged in
        $authMiddleware = new AuthMiddleware();
        $authMiddleware->handle();
        
        $this->userModel = new User();
        $this->orderModel = new Order();
    }
    
    public function profile() {
        $userId = $_SESSION['user_id'];
        
        // Get user details
        $user = $this->userModel->findById($userId);
        
        // Check if user exists
        if ($user === false) {
            $_SESSION['error'] = 'User not found. Please login again.';
            redirect('auth/logout');
            return;
        }
        
        // Handle both direct array return and PDOStatement
        if (is_object($user) && method_exists($user, 'fetch')) {
            $user = $user->fetch(PDO::FETCH_ASSOC);
            
            // If fetch returns false (no results)
            if ($user === false) {
                $_SESSION['error'] = 'User not found. Please login again.';
                redirect('auth/logout');
                return;
            }
        }
        
        // Load profile view
        require_once 'app/views/users/profile.php';
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            
            // Get form data
            $data = [
                'firstname' => $_POST['firstname'] ?? '',
                'lastname' => $_POST['lastname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'current_password' => $_POST['current_password'] ?? '',
                'new_password' => $_POST['new_password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? ''
            ];
            
            // Validate input
            $errors = [];
            
            if (empty($data['firstname'])) {
                $errors[] = 'First name is required';
            }
            
            if (empty($data['lastname'])) {
                $errors[] = 'Last name is required';
            }
            
            if (empty($data['email'])) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }
            
            // Check if password is being updated
            if (!empty($data['new_password'])) {
                if (empty($data['current_password'])) {
                    $errors[] = 'Current password is required';
                }
                
                if (strlen($data['new_password']) < 6) {
                    $errors[] = 'New password must be at least 6 characters';
                }
                
                if ($data['new_password'] !== $data['confirm_password']) {
                    $errors[] = 'New passwords do not match';
                }
            }
            
            if (empty($errors)) {
                // Update user profile
                $result = $this->userModel->updateProfile($userId, $data);
                
                if ($result) {
                    $_SESSION['success'] = 'Profile updated successfully';
                    
                    // Update session variables with isset checks
                    $_SESSION['user_name'] = (isset($data['firstname']) ? $data['firstname'] : '') . ' ' . (isset($data['lastname']) ? $data['lastname'] : '');
                    $_SESSION['user_email'] = $data['email'];
                } else {
                    $_SESSION['error'] = 'Failed to update profile';
                }
            } else {
                $_SESSION['errors'] = $errors;
            }
        }
        
        // Redirect back to profile page with query parameter format
        redirect('?page=user&action=profile');
    }
    /**
     * Handle user orders
     */
    public function orders() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Please login to view your orders";
            redirect('?page=auth&action=login');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Get user details
        $user = $this->userModel->getUserById($userId);
        
        // Get user orders - now returns array directly
        $orders = $this->orderModel->getUserOrders($userId);
        
        if (empty($orders)) {
            $_SESSION['error'] = "No orders found";
        }
        
        // Load orders view
        require_once 'app/views/users/orders.php';
    }
    
    // Removed duplicate orders() method
    
    /**
     * Display user addresses
     */
    public function addresses() {
        $userId = $_SESSION['user_id'];
        
        // Get user details
        $user = $this->userModel->getUserById($userId);
        
        // Get user addresses
        $addresses = $this->userModel->getUserAddresses($userId);
        
        // Load view
        require_once 'app/views/users/addresses.php';
    } // Added missing closing brace here
    
    /**
     * Save user address
     */
    public function saveAddress() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            
            // Get form data
            $data = [
                'address_id' => $_POST['address_id'] ?? '',
                'address' => $_POST['address'] ?? '',
                'zip' => $_POST['zip'] ?? '',
                'town' => $_POST['town'] ?? '',
                'country_id' => $_POST['country_id'] ?? ''
            ];
            
            // Validate input
            $errors = [];
            
            if (empty($data['address'])) {
                $errors[] = 'Street address is required';
            }
            
            if (empty($data['zip'])) {
                $errors[] = 'Postal code is required';
            }
            
            if (empty($data['town'])) {
                $errors[] = 'City is required';
            }
            
            if (empty($errors)) {
                // Update or create address
                $result = $this->userModel->saveAddress($userId, $data);
                
                if ($result) {
                    $_SESSION['success'] = 'Address saved successfully';
                } else {
                    $_SESSION['error'] = 'Failed to save address';
                }
            } else {
                $_SESSION['errors'] = $errors;
            }
        }
        
        // Redirect back to addresses page
        redirect('user/addresses');
    }
}
?>