<?php
class ErrorHandler {
    public static function handleException($exception) {
        error_log($exception->getMessage());
        
        // Clear any previous output
        if (ob_get_length()) ob_clean();
        
        // Check if it's an AJAX request
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        if ($isAjax) {
            header('Content-Type: application/json');
            $response = [
                'success' => false,
                'message' => defined('ENVIRONMENT') && ENVIRONMENT === 'development' 
                    ? $exception->getMessage() 
                    : 'An error occurred. Please try again later.'
            ];
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                $response['trace'] = $exception->getTraceAsString();
            }
            echo json_encode($response);
        } else {
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border-radius: 4px;'>";
                echo "<h3>Error:</h3>";
                echo "<p>" . htmlspecialchars($exception->getMessage()) . "</p>";
                echo "<pre>" . htmlspecialchars($exception->getTraceAsString()) . "</pre>";
                echo "</div>";
            } else {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border-radius: 4px;'>";
                echo "<p>An error occurred. Please try again later.</p>";
                echo "</div>";
            }
        }
    }
}
?>