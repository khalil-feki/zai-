<?php
// Check if running within Dolibarr
if (isset($website) && isset($websitepage)) {
    // We're running inside Dolibarr
    define('RUNNING_IN_DOLIBARR', true);
    
    // Define BASE_URL for Dolibarr environment
    if (!defined('BASE_URL')) {
        define('BASE_URL', $website->virtualhost.'/');
    }
} else {
    // We're running standalone
    define('RUNNING_IN_DOLIBARR', false);
    
    // Keep existing BASE_URL if defined, otherwise set a default
    if (!defined('BASE_URL')) {
        // Get the current URL for standalone mode
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
        $scriptPath = $scriptPath !== '/' ? $scriptPath . '/' : '/';
        define('BASE_URL', $protocol . $domainName . $scriptPath);
    }
}

// Include configuration - Fix the path to the correct config file
require_once 'app/config/config.php';

// Process form submission
$success = false;
$error = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ticket'])) {
    // Connect to database
    try {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        
        // Get form data
        $email = $_POST['email'] ?? '';
        $requestType = $_POST['request_type'] ?? '';
        $ticketGroup = $_POST['ticket_group'] ?? '';
        $severity = $_POST['severity'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $messageContent = $_POST['message'] ?? '';
        
        // Validate form data
        if (empty($email) || empty($subject) || empty($messageContent)) {
            $error = true;
            $message = 'Please fill in all required fields.';
        } else {
            // Generate a reference number for the ticket
            $ticketRef = 'TICKET' . date('YmdHis');
            
            // Generate a unique track_id
            $trackId = 'TK' . date('YmdHis') . rand(1000, 9999);
            
            // Insert into h8pd_ticket table instead of llx_ticket
            $sql = "INSERT INTO h8pd_ticket (ref, track_id, fk_soc, fk_user_create, subject, message, type_code, category_code, severity_code, datec, origin_email, fk_statut)
                    VALUES (?, ?, 0, 0, ?, ?, ?, ?, ?, NOW(), ?, 0)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $ticketRef,
                $trackId,
                $subject,
                $messageContent,
                $requestType,
                $ticketGroup,
                $severity,
                $email
            ]);
            
            // Handle file upload if present
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/tickets/';
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = basename($_FILES['attachment']['name']);
                $uploadFile = $uploadDir . $ticketRef . '_' . $fileName;
                
                if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                    // Insert file reference into database - also update table name if needed
                    $filesSql = "INSERT INTO h8pd_ecm_files (label, filepath, filename, src_object_type, src_object_id, datec)
                                VALUES (?, ?, ?, 'ticket', LAST_INSERT_ID(), NOW())";
                    $filesStmt = $pdo->prepare($filesSql);
                    $filesStmt->execute([
                        $fileName,
                        $uploadDir,
                        $fileName
                    ]);
                }
            }
            
            $success = true;
            $message = 'Your ticket has been submitted successfully. Reference: ' . $ticketRef;
        }
    } catch (PDOException $e) {
        $error = true;
        $message = 'Database error: ' . $e->getMessage();
    }
}

// Only include header if not running in Dolibarr
if (!RUNNING_IN_DOLIBARR) {
    require_once 'app/views/containers/header.php';
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #1cc88a;
        --accent-color: #f6c23e;
        --dark-color: #5a5c69;
        --light-color: #f8f9fc;
        --danger-color: #e74a3b;
        --success-color: #1cc88a;
        --warning-color: #f6c23e;
        --info-color: #36b9cc;
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --gradient-accent: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
    }
    
    body {
        font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }
    
    .ticket-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        min-height: calc(100vh - 100px);
    }
    
    .ticket-header {
        margin-bottom: 3rem;
        position: relative;
        padding-bottom: 1rem;
        text-align: center;
    }
    
    .ticket-header h1 {
        color: white;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        position: relative;
        display: inline-block;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .ticket-header h1:after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 2px;
    }
    
    .ticket-form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        margin-bottom: 3rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .ticket-form-container:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }
    
    .ticket-form-container:hover {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    
    .form-section-title {
        font-size: 1.2rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        display: flex;
    }
    
    .form-group label {
        width: 200px;
        font-weight: 600;
        color: var(--dark-color);
        padding-top: 8px;
    }
    
    .form-group .form-control-wrapper {
        flex: 1;
        position: relative;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.2s ease;
        background-color: #f8f9fc;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        outline: none;
    }
    
    select.form-control {
        height: 48px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%235a5c69' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 35px;
    }
    
    /* Make request type field bigger */
    select[name="request_type"] {
        height: 56px;
        font-size: 17px;
        padding: 15px 40px 15px 18px;
        font-weight: 500;
    }
    
    /* Make ticket group and severity fields bigger */
    select[name="ticket_group"],
    select[name="severity"] {
        height: 56px;
        font-size: 17px;
        padding: 15px 40px 15px 18px;
        font-weight: 500;
    }
    
    textarea.form-control {
        min-height: 180px;
        resize: vertical;
    }
    
    .instruction-box {
        background-color: rgba(246, 194, 62, 0.1);
        border-left: 4px solid var(--accent-color);
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 0 8px 8px 0;
        color: #856404;
        font-size: 15px;
        line-height: 1.6;
    }
    
    .btn-container {
        text-align: center;
        margin-top: 2.5rem;
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn:hover:before {
        left: 100%;
    }
    
    .btn-primary {
        background: var(--gradient-primary);
        color: white;
    }
    
    .btn-secondary {
        background: var(--gradient-secondary);
        color: white;
    }
    
    /* Improved button styling */
    .btn-create {
        min-width: 160px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    
    .btn-cancel {
        min-width: 140px;
        background: linear-gradient(135deg, #858796 0%, #60616f 100%);
        box-shadow: 0 4px 15px rgba(133, 135, 150, 0.3);
    }
    
    .btn-create:hover {
        background: linear-gradient(135deg, #2e59d9 0%, #1a4aa3 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
    }
    
    .btn-cancel:hover {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(133, 135, 150, 0.4);
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary:hover {
        box-shadow: 0 8px 25px rgba(78, 115, 223, 0.3);
    }
    
    .btn-secondary:hover {
        box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);
    }
    
    .alert {
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 8px;
        font-weight: 500;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
    }
    
    .alert:before {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        margin-right: 15px;
        font-size: 20px;
    }
    
    .alert-success {
        background-color: rgba(28, 200, 138, 0.1);
        color: #0f6848;
        border-left: 4px solid var(--success-color);
    }
    
    .alert-success:before {
        content: '\f058';
        color: var(--success-color);
    }
    
    .alert-error {
        background-color: rgba(231, 74, 59, 0.1);
        color: #a42f2f;
        border-left: 4px solid var(--danger-color);
    }
    
    .alert-error:before {
        content: '\f057';
        color: var(--danger-color);
    }
    
    .file-upload {
        position: relative;
        display: inline-block;
    }
    
    .file-upload-btn {
        background-color: var(--primary-color);
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .file-upload-btn:hover {
        background-color: #2e59d9;
    }
    
    .file-upload input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-name {
        margin-left: 15px;
        font-style: italic;
        color: var(--dark-color);
    }
    
    /* Contact info and map section */
    .contact-section-title {
        font-size: 3rem;
        color: white;
        margin-bottom: 4rem;
        text-align: center;
        font-weight: 800;
        position: relative;
        padding-bottom: 1.5rem;
        letter-spacing: -0.02em;
        animation: titleGlow 0.8s ease-out both;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .contact-section-title::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(172, 150, 194, 0.1));
        border-radius: 20px;
        filter: blur(20px);
        z-index: -1;
        animation: pulse 2s ease-in-out infinite;
    }
    
    .contact-section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 6px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c, #667eea);
        background-size: 200% 100%;
        border-radius: 3px;
        animation: gradientShift 3s ease-in-out infinite;
    }
    
    .contact-info-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        margin-top: 4rem;
        perspective: 1000px;
        animation: containerSlideIn 1s ease-out 0.3s both;
    }
    
    .contact-info {
        display: flex;
        flex-direction: column;
        position: relative;
    }
    
    .contact-info::before {
        content: '';
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1), rgba(240, 147, 251, 0.1));
        border-radius: 30px;
        filter: blur(30px);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.6s ease;
    }
    
    .contact-info:hover::before {
        opacity: 1;
    }
    
    .map-container {
        flex: 2;
        min-width: 300px;
        height: 450px;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }
    
    .map-container .contact-card {
        height: 400px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    
    .map-container .contact-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-accent);
        z-index: 1;
    }
    
    .map-container .contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    
    .contact-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .contact-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-accent);
    }
    
    .contact-card:hover {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    
    .contact-card h2 {
        color: var(--primary-color);
        margin-bottom: 2rem;
        font-weight: 700;
        position: relative;
        padding-bottom: 0.8rem;
    }
    
    .contact-card h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        border-radius: 24px;
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
    }
    
    .contact-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        opacity: 0;
        transition: opacity 0.6s ease;
        z-index: -1;
    }
    
    .contact-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
    }
    
    .contact-item:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%);
        transform: translateY(-8px) rotateX(5deg) scale(1.02);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .contact-item:hover::before {
        opacity: 1;
    }
    
    .contact-item:hover::after {
        transform: scaleX(1);
    }
    
    .contact-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 2rem;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transform-style: preserve-3d;
    }
    
    .contact-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #4facfe 100%);
        opacity: 0;
        transition: opacity 0.6s ease;
        border-radius: 20px;
    }
    
    .contact-icon::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120%;
        height: 120%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.6s ease;
        border-radius: 50%;
    }
    
    .contact-item:hover .contact-icon {
        transform: translateY(-3px) rotateY(15deg) rotateX(10deg) scale(1.1);
        box-shadow: 0 20px 50px rgba(102, 126, 234, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }
    
    .contact-item:hover .contact-icon::before {
        opacity: 1;
    }
    
    .contact-item:hover .contact-icon::after {
        opacity: 1;
    }
    
    .contact-icon i {
        color: white;
        font-size: 1.6rem;
        position: relative;
        z-index: 2;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .contact-item:hover .contact-icon i {
        transform: scale(1.2) rotateZ(10deg);
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }
    
    .contact-text h4 {
        margin: 0 0 0.75rem 0;
        color: black;
        font-weight: 600;
        font-size: 1.2rem;
        text-shadow: none;
    }
    
    .contact-text p {
        margin: 0 0 0.4rem 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 1rem;
        line-height: 1.5;
        transition: color 0.3s ease;
    }
    
    .contact-item:hover .contact-text p {
        color: rgba(255, 255, 255, 0.95);
    }
    
    .social-links {
        display: flex;
        margin-top: 3rem;
        justify-content: center;
        gap: 1.5rem;
        animation: socialFloat 1.2s ease-out 0.8s both;
        perspective: 1000px;
    }
    
    .social-link {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        color: white;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        font-size: 1.4rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .social-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        opacity: 0;
        transition: opacity 0.6s ease;
        border-radius: 18px;
        z-index: 0;
    }
    
    .social-link::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
        border-radius: 50%;
        transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        z-index: 1;
    }
    
    .social-link i {
        position: relative;
        z-index: 2;
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .social-link:hover {
        transform: translateY(-8px) rotateY(15deg) rotateX(10deg) scale(1.15);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
    }
    
    .social-link:hover::before {
        opacity: 1;
    }
    
    .social-link:hover::after {
        transform: translate(-50%, -50%) scale(1.2);
    }
    
    .social-link:hover i {
        transform: scale(1.2) rotateZ(15deg);
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    
    .social-link:nth-child(1) { animation-delay: 0.9s; }
    .social-link:nth-child(2) { animation-delay: 1.0s; }
    .social-link:nth-child(3) { animation-delay: 1.1s; }
    .social-link:nth-child(4) { animation-delay: 1.2s; }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideInFromLeft {
        from {
            opacity: 0;
            transform: translateX(-100%) translateX(-50%);
        }
        to {
            opacity: 1;
            transform: translateX(-50%);
        }
    }
    
    @keyframes titleGlow {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.3;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.1);
            opacity: 0.6;
        }
    }
    
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    
    @keyframes containerSlideIn {
        from {
            opacity: 0;
            transform: translateY(50px) rotateX(-10deg);
        }
        to {
            opacity: 1;
            transform: translateY(0) rotateX(0deg);
        }
    }
    
    @keyframes socialFloat {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.8);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @media (max-width: 768px) {
        .ticket-container {
            padding: 1rem;
        }
        
        .ticket-header h1 {
            font-size: 2rem;
        }
        
        .contact-section-title {
            font-size: 2rem;
            margin-bottom: 2rem;
        }
        
        .ticket-form-container,
        .contact-card {
            padding: 1.5rem;
        }
        
        .contact-info-container {
            flex-direction: column;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .contact-item {
            padding: 1.2rem;
            margin-bottom: 1.5rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            margin-right: 1rem;
        }
        
        .contact-icon i {
            font-size: 1.2rem;
        }
        
        .contact-text h4 {
            font-size: 1.1rem;
        }
        
        .contact-text p {
            font-size: 0.9rem;
        }
        
        .social-link {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
        
        .map-container .contact-card {
            height: 300px;
        }
        
        .form-group {
            flex-direction: column;
        }
        
        .form-group label {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .btn-container {
            display: flex;
            flex-direction: column;
        }
        
        .btn-secondary {
            margin-left: 0;
            margin-top: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .ticket-header h1 {
            font-size: 1.8rem;
        }
        
        .contact-section-title {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .contact-info-container {
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .contact-item {
            padding: 1rem;
            margin-bottom: 1rem;
            flex-direction: column;
            text-align: center;
        }
        
        .contact-icon {
            margin-right: 0;
            margin-bottom: 1rem;
            align-self: center;
        }
        
        .social-links {
            margin-top: 2rem;
            gap: 0.8rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        .map-container .contact-card {
            height: 250px;
        }
        
        .btn {
            padding: 10px 25px;
            font-size: 14px;
        }
    }
</style>

<div class="ticket-container">
    <div class="ticket-header">
        <h1>Créer un nouveau ticket de support</h1>
        <p>Utilisez ce formulaire pour soumettre une demande d'assistance à notre équipe</p>
    </div>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <div class="ticket-form-container">
        <h3 class="form-section-title">Informations de contact</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="form-control-wrapper">
                    <input type="email" id="email" name="email" class="form-control" required placeholder="Votre adresse email">
                </div>
            </div>
            
            <h3 class="form-section-title">Détails du ticket</h3>
            
            <div class="form-group">
                <label for="request_type">Type de demande</label>
                <div class="form-control-wrapper">
                    <select id="request_type" name="request_type" class="form-control" required>
                        <option value="" disabled selected>Sélectionnez un type de demande</option>
                        <option value="COM">Question commerciale</option>
                        <option value="HELP">Aide technique</option>
                        <option value="ISSUE">Signaler un problème</option>
                        <option value="OTHER">Autre</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="ticket_group">Groupe du ticket</label>
                <div class="form-control-wrapper">
                    <select id="ticket_group" name="ticket_group" class="form-control" required>
                        <option value="" disabled selected>Sélectionnez un groupe</option>
                        <option value="support">Support</option>
                        <option value="billing">Facturation</option>
                        <option value="technical">Technique</option>
                        <option value="general">Général</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="severity">Sévérité</label>
                <div class="form-control-wrapper">
                    <select id="severity" name="severity" class="form-control" required>
                        <option value="" disabled selected>Sélectionnez un niveau de sévérité</option>
                        <option value="LOW">Normal</option>
                        <option value="NORMAL">Moyen</option>
                        <option value="HIGH">Élevé</option>
                        <option value="BLOCKING">Bloquant</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="subject">Sujet</label>
                <div class="form-control-wrapper">
                    <input type="text" id="subject" name="subject" class="form-control" required placeholder="Titre de votre demande">
                </div>
            </div>
            
            <div class="instruction-box">
                <i class="fas fa-info-circle" style="margin-right: 10px;"></i>
                Veuillez décrire précisément votre question. Fournissez le plus d'informations possible pour nous permettre d'identifier correctement votre demande.
            </div>
            
            <div class="form-group">
                <label for="message">Message</label>
                <div class="form-control-wrapper">
                    <textarea id="message" name="message" class="form-control" required placeholder="Décrivez votre problème ou votre question en détail..."></textarea>
                </div>
            </div>
            

            
            <div class="btn-container">
                <button type="submit" name="submit_ticket" class="btn btn-primary btn-create">
                    <i class="fas fa-paper-plane" style="margin-right: 8px;"></i>Créer ticket
                </button>
                <button type="button" class="btn btn-secondary btn-cancel" onclick="window.location.href='<?php echo BASE_URL; ?>'">
                    <i class="fas fa-times" style="margin-right: 8px;"></i>Annuler
                </button>
            </div>
        </form>
    </div>
    
    <!-- Contact Information and Map Section -->
    <h2 class="contact-section-title">Nous contacter</h2>
    
    <div class="contact-info-container">
        <div class="contact-info">
            <div class="contact-card">
                <h2>Nos Coordonnées</h2>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Adresse</h4>
                        <p>123 Avenue de la République</p>
                        <p>75011 Paris, France</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Téléphone</h4>
                        <p>+33 1 23 45 67 89</p>
                        <p>+33 9 87 65 43 21</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Email</h4>
                        <p>support@zaiecommerce.com</p>
                        <p>info@zaiecommerce.com</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-text">
                        <h4>Heures d'ouverture</h4>
                        <p>Lundi - Vendredi: 9h00 - 18h00</p>
                        <p>Samedi: 10h00 - 15h00</p>
                        <p>Dimanche: Fermé</p>
                    </div>
                </div>
                
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        
        <div class="map-container">
            <div class="contact-card" style="padding: 0; overflow: hidden;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.142047033408!2d2.3354330157170955!3d48.87456857928921!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e38f817b573%3A0x48d69c30470e7aeb!2sRue%20du%20Faubourg%20Saint-Honor%C3%A9%2C%2075008%20Paris!5e0!3m2!1sen!2sfr!4v1623252352526!5m2!1sen!2sfr" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload display
    const fileInput = document.getElementById('attachment');
    const fileNameDisplay = document.getElementById('file-name-display');
    const uploadBtn = document.getElementById('upload-btn');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = 'Aucun fichier choisi';
        }
    });
    
    uploadBtn.addEventListener('click', function() {
        fileInput.click();
    });
});
</script>

<?php if (!RUNNING_IN_DOLIBARR): ?>
<?php require_once 'app/views/containers/footer.php'; ?>
<?php endif; ?>