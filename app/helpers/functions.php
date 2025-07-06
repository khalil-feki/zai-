<?php
// Make sure there's no whitespace before this opening PHP tag
// Assuming this is line 4 where the error occurs
function redirect($url) {
    // Add this to see if there was output before
    if (headers_sent($file, $line)) {
        error_log("Headers already sent in $file on line $line");
    }
    header("Location: $url");
    exit;
}
// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Format price
function formatPrice($price) {
    return number_format($price, 2);
}

// Sanitize input
/**
 * Sanitize user input
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function sanitize($data) {
    if ($data === null) {
        return '';
    }
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

// Generate random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Get current date and time in MySQL format
function getCurrentDateTime() {
    return date('Y-m-d H:i:s');
}

// Format date
function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

// Truncate text
function truncateText($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

// Flash messages
function setFlashMessage($type, $message) {
    if ($type === 'error') {
        $_SESSION['error'] = $message;
    } elseif ($type === 'success') {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION[$type] = $message;
    }
}

// Get flash message and clear it
function getFlashMessage($type) {
    $message = '';
    if (isset($_SESSION[$type])) {
        $message = $_SESSION[$type];
        unset($_SESSION[$type]);
    }
    return $message;
}

// Display flash messages
function displayFlashMessages() {
    $output = '';
    
    if (isset($_SESSION['success'])) {
        $output .= '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    
    if (isset($_SESSION['error'])) {
        $output .= '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    
    if (isset($_SESSION['info'])) {
        $output .= '<div class="alert alert-info">' . $_SESSION['info'] . '</div>';
        unset($_SESSION['info']);
    }
    
    if (isset($_SESSION['warning'])) {
        $output .= '<div class="alert alert-warning">' . $_SESSION['warning'] . '</div>';
        unset($_SESSION['warning']);
    }
    
    return $output;
}

// Get active class for navigation
function isActiveRoute($route) {
    $url = isset($_GET['url']) ? $_GET['url'] : '';
    return (strpos($url, $route) === 0) ? 'active' : '';
}

// Generate pagination links
function generatePagination($currentPage, $totalPages, $urlPattern) {
    $links = '';
    
    if ($totalPages <= 1) {
        return $links;
    }
    
    if ($currentPage > 1) {
        $links .= '<a href="' . sprintf($urlPattern, $currentPage - 1) . '" class="pagination-link">&laquo; Previous</a>';
    }
    
    $startPage = max(1, $currentPage - 2);
    $endPage = min($totalPages, $currentPage + 2);
    
    if ($startPage > 1) {
        $links .= '<a href="' . sprintf($urlPattern, 1) . '" class="pagination-link">1</a>';
        if ($startPage > 2) {
            $links .= '<span class="pagination-ellipsis">...</span>';
        }
    }
    
    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $currentPage) {
            $links .= '<span class="pagination-link current">' . $i . '</span>';
        } else {
            $links .= '<a href="' . sprintf($urlPattern, $i) . '" class="pagination-link">' . $i . '</a>';
        }
    }
    
    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) {
            $links .= '<span class="pagination-ellipsis">...</span>';
        }
        $links .= '<a href="' . sprintf($urlPattern, $totalPages) . '" class="pagination-link">' . $totalPages . '</a>';
    }
    
    if ($currentPage < $totalPages) {
        $links .= '<a href="' . sprintf($urlPattern, $currentPage + 1) . '" class="pagination-link">Next &raquo;</a>';
    }
    
    return '<div class="pagination">' . $links . '</div>';
}

// Calculate total pages for pagination
function calculateTotalPages($totalItems, $itemsPerPage) {
    return ceil($totalItems / $itemsPerPage);
}

// Format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

// Check if string starts with a specific substring
function startsWith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

// Check if string ends with a specific substring
function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}

// Validate email address
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Generate slug from string
function generateSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

// Get file extension
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// Check if file is an image
function isImage($filename) {
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = getFileExtension($filename);
    return in_array($extension, $allowedTypes);
}

// Format currency
function formatCurrency($amount, $currency = 'USD') {
    switch ($currency) {
        case 'EUR':
            return number_format($amount, 2, ',', '.') . ' dt';
        case 'GBP':
            return '£' . number_format($amount, 2);
        default:
            return '$' . number_format($amount, 2);
    }
}

// Get time ago
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return 'just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('F j, Y', $time);
    }
}

// Clean input array
function cleanInput($data) {
    $clean = [];
    foreach ($data as $key => $value) {
        $clean[$key] = sanitize($value);
    }
    return $clean;
}

// Generate random order reference
function generateOrderRef() {
    return 'ORD-' . date('Ymd') . '-' . strtoupper(generateRandomString(6));
}

// Calculate discount
function calculateDiscount($price, $discountPercentage) {
    return $price * ($discountPercentage / 100);
}

// Get user IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Debug function
function debug($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

// Secure debug (only works in development environment)
function dd($data) {
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        debug($data);
        die();
    }
}

// Generate CSRF token
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Add CSRF field to form
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">';
}

// Check if request is AJAX
/**
 * Check if the request is an AJAX request
 * @return bool True if AJAX request, false otherwise
 */
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Convert array to JSON response
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Get current URL
function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

// Get base URL
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
}

// Validate required fields
function validateRequired($data, $fields) {
    $errors = [];
    foreach ($fields as $field) {
        if (empty($data[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
        }
    }
    return $errors;
}

// Escape JSON for HTML output
function escapeJson($json) {
    return htmlspecialchars($json, ENT_QUOTES, 'UTF-8');
}

// Remove the closing PHP tag to prevent accidental whitespace