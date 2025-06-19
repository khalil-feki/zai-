<?php
class AuthMiddleware {
    public function handle() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please log in to access this page';
            redirect('?page=auth&action=login');
        }
    }
}
?>