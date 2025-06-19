<?php
require_once 'app/models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        // If already logged in, redirect to home
        if (isLoggedIn()) {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validate input
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Please enter both email and password';
                redirect('?page=auth&action=login');
                return;
            }
            
            // Attempt login
            $userModel = new User();
            $user = $userModel->login($username, $password);
            
            if ($user) {
                // Set session variables
                $_SESSION['user_id'] = $user['rowid'];
                $_SESSION['user_name'] = $user['nom'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to home page after successful login - using direct header
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $_SESSION['error'] = 'Invalid email or password';
                redirect('?page=auth&action=login');
            }
        } else {
            // Display login form
            require_once 'app/views/auth/login.php';
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process registration form
            $data = [
                'username' => $_POST['username'] ?? '',
                'firstname' => $_POST['firstname'] ?? '',
                'lastname' => $_POST['lastname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? ''
            ];
            
            // Validate input
            $errors = [];
            
            if (empty($data['username'])) {
                $errors[] = 'Username is required';
            }
            
            if (empty($data['firstname'])) {
                $errors[] = 'First name is required';
            }
            
            if (empty($data['email'])) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }
            
            if (empty($data['password'])) {
                $errors[] = 'Password is required';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            
            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = 'Passwords do not match';
            }
            
            if (empty($errors)) {
                // Register user
                $userId = $this->userModel->register($data);
                
                if ($userId) {
                    $_SESSION['success'] = 'Registration successful. Please log in.';
                    redirect('?page=auth&action=login');
                } else {
                    $_SESSION['error'] = 'Registration failed. Please try again.';
                    require_once 'app/views/auth/register.php';
                }
            } else {
                $_SESSION['errors'] = $errors;
                require_once 'app/views/auth/register.php';
            }
        } else {
            // Display registration form
            require_once 'app/views/auth/register.php';
        }
    }
    
    public function logout() {
        // Destroy session
        session_unset();
        session_destroy();
        
        // Redirect to login page using direct header
        header('Location: ' . BASE_URL . '?page=auth&action=login');
        exit;
    }

    /**
     * Handle forgot password requests
     */
    public function forgotPassword() {
        // Display the forgot password form
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once 'app/views/auth/forgot-password.php';
            return;
        }
        
        // Process the forgot password request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (empty($email)) {
                $_SESSION['error'] = 'Email address is required';
                redirect(BASE_URL . '?page=auth&action=forgot-password');
                return;
            }
            
            // Check if user exists
            require_once 'app/models/User.php';
            $userModel = new User();
            $user = $userModel->findByEmail($email);
            
            if (!$user) {
                // Don't reveal that the email doesn't exist for security reasons
                $_SESSION['success'] = 'If your email exists in our system, you will receive a password reset link shortly.';
                redirect(BASE_URL . '?page=auth&action=forgot-password');
            }
            
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Save the token in the database
            $saved = $userModel->saveResetToken($user['rowid'], $token, $expires);
            
            if (!$saved) {
                $_SESSION['error'] = 'An error occurred. Please try again later.';
                redirect(BASE_URL . '?page=auth&action=forgot-password');
            }
            
            // Send the reset email
            $resetLink = BASE_URL . '?page=auth&action=reset-password&token=' . $token . '&email=' . urlencode($email);
            $subject = 'Password Reset Request';
            $message = "Hello,\n\nYou have requested to reset your password. Please click the link below to reset your password:\n\n$resetLink\n\nThis link will expire in 1 hour.\n\nIf you did not request this, please ignore this email.\n\nRegards,\nThe Team";
            $headers = 'From: noreply@yourdomain.com' . "\r\n" .
                               'Reply-To: noreply@yourdomain.com' . "\r\n" .
                               'X-Mailer: PHP/' . phpversion();
            
            mail($email, $subject, $message, $headers);
            
            $_SESSION['success'] = 'If your email exists in our system, you will receive a password reset link shortly.';
            redirect(BASE_URL . '?page=auth&action=forgot-password');
        }
    }

    /**
     * Handle password reset
     */
    public function resetPassword() {
        // Display the reset password form
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $token = $_GET['token'] ?? '';
            $email = $_GET['email'] ?? '';
            
            if (empty($token) || empty($email)) {
                $_SESSION['error'] = 'Invalid password reset link';
                redirect(BASE_URL . '?page=auth&action=login');
            }
            
            // Verify the token
            require_once 'app/models/User.php';
            $userModel = new User();
            $valid = $userModel->verifyResetToken($email, $token);
            
            if (!$valid) {
                $_SESSION['error'] = 'Invalid or expired password reset link';
                redirect(BASE_URL . '?page=auth&action=login');
            }
            
            require_once 'app/views/auth/reset-password.php';
            return;
        }
        
        // Process the reset password request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($token) || empty($email)) {
                $_SESSION['error'] = 'Invalid password reset link';
                redirect(BASE_URL . '?page=auth&action=login');
            }
            
            if (empty($password)) {
                $_SESSION['error'] = 'Password is required';
                redirect(BASE_URL . '?page=auth&action=reset-password&token=' . urlencode($token) . '&email=' . urlencode($email));
            }
            
            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
                redirect(BASE_URL . '?page=auth&action=reset-password&token=' . urlencode($token) . '&email=' . urlencode($email));
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters';
                redirect(BASE_URL . '?page=auth&action=reset-password&token=' . urlencode($token) . '&email=' . urlencode($email));
            }
            
            // Verify the token again
            require_once 'app/models/User.php';
            $userModel = new User();
            $user = $userModel->getUserByEmailAndToken($email, $token);
            
            if (!$user) {
                $_SESSION['error'] = 'Invalid or expired password reset link';
                redirect(BASE_URL . '?page=auth&action=login');
            }
            
            // Update the password
            $updated = $userModel->updatePassword($user['rowid'], $password);
            
            if (!$updated) {
                $_SESSION['error'] = 'Failed to update password';
                redirect(BASE_URL . '?page=auth&action=reset-password&token=' . urlencode($token) . '&email=' . urlencode($email));
            }
            
            // Clear the reset token
            $userModel->clearResetToken($user['rowid']);
            
            $_SESSION['success'] = 'Your password has been updated successfully. You can now login with your new password.';
            redirect(BASE_URL . '?page=auth&action=login');
        }
    }
}
?>