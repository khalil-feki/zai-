<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';

// Initialize variables
$success = false;
$error = '';
$formData = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'zip' => '',
    'town' => '',
    'note' => ''
];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $formData = [
        'firstname' => $_POST['firstname'] ?? '',
        'lastname' => $_POST['lastname'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'address' => $_POST['address'] ?? '',
        'zip' => $_POST['zip'] ?? '',
        'town' => $_POST['town'] ?? '',
        'note' => $_POST['message'] ?? '',
        'status' => 1 // Active status
    ];
    
    // Validate form data
    if (empty($formData['firstname'])) {
        $error = 'First name is required';
    } elseif (empty($formData['lastname'])) {
        $error = 'Last name is required';
    } elseif (empty($formData['email'])) {
        $error = 'Email is required';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        try {
            // Use the Database class from app/config/database.php
            $database = new Database();
            $db = $database->getConnection();
            
            // Save contact to database (h8pd_socpeople table)
            $sql = "INSERT INTO h8pd_socpeople (
                        firstname, lastname, email, phone, address, zip, town, note_private, 
                        statut, entity, datec, fk_user_creat
                    ) VALUES (
                        :firstname, :lastname, :email, :phone, :address, :zip, :town, :note, 
                        :status, 1, NOW(), 1
                    )";
            
            // Remove debug output and just execute the query
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                ':firstname' => $formData['firstname'],
                ':lastname' => $formData['lastname'],
                ':email' => $formData['email'],
                ':phone' => $formData['phone'],
                ':address' => $formData['address'],
                ':zip' => $formData['zip'],
                ':town' => $formData['town'],
                ':note' => $formData['note'],
                ':status' => $formData['status']
            ]);
            
            if ($result) {
                $success = true;
                // Reset form data after successful submission
                $formData = [
                    'firstname' => '',
                    'lastname' => '',
                    'email' => '',
                    'phone' => '',
                    'address' => '',
                    'zip' => '',
                    'town' => '',
                    'note' => ''
                ];
                
                // Set success message
                $_SESSION['success'] = 'Thank you for contacting us! Your message has been received. We will get back to you soon.';
            } else {
                $error = 'Failed to save contact information';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Include header
$pageTitle = "Contact Us";
$currentPage = "contact";
include_once 'app/views/containers/header.php';
?>

<div class="contact-container">
    <div class="contact-header">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
    </div>
    
    <div class="contact-content">
        <div class="contact-info">
            <h3>Our Information</h3>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong><br>
            123 Business Street<br>
            City, State 12345</p>
            
            <p><i class="fas fa-phone"></i> <strong>Phone:</strong><br>
            +1 (123) 456-7890</p>
            
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong><br>
            info@example.com</p>
            
            <p><i class="fas fa-clock"></i> <strong>Business Hours:</strong><br>
            Monday - Friday: 9:00 AM - 5:00 PM<br>
            Saturday - Sunday: Closed</p>
            
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
        
        <div class="contact-form-container">
            <h3>Send Us a Message</h3>
            <form method="post" action="contact.php" class="contact-form">
                <div class="form-row" style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="firstname">First Name *</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($formData['firstname']); ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="lastname">Last Name *</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($formData['lastname']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row" style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($formData['phone']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($formData['address']); ?>">
                </div>
                
                <div class="form-row" style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="zip">Postal Code</label>
                        <input type="text" id="zip" name="zip" value="<?php echo htmlspecialchars($formData['zip']); ?>">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="town">City</label>
                        <input type="text" id="town" name="town" value="<?php echo htmlspecialchars($formData['town']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="5" required><?php echo htmlspecialchars($formData['note']); ?></textarea>
                </div>
                
                <button type="submit">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>
    
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a23e28c1191%3A0x49f75d3281df052a!2s150%20Park%20Row%2C%20New%20York%2C%20NY%2010007%2C%20USA!5e0!3m2!1sen!2sbg!4v1579802149804!5m2!1sen!2sbg" allowfullscreen="" loading="lazy"></iframe>
    </div>
</div>

<?php
// Include footer
include_once 'app/views/containers/footer.php';
?>