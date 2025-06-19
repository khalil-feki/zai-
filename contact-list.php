<?php
require_once 'app/config/config.php';
require_once 'app/utils/DolibarrDatabase.php';

// Initialize database connection
$db = new DolibarrDatabase();

// Get contacts from database
try {
    $contacts = $db->getContacts(50, 0); // Get up to 50 contacts
} catch (Exception $e) {
    // Log the error for administrators
    error_log("Contact list error: " . $e->getMessage());
    // Show a more user-friendly message
    $error = 'Unable to retrieve contacts. Please try again later.';
    $contacts = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            padding-top: 56px;
            padding-bottom: 20px;
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .page-header {
            background-color: #007bff;
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
        }
        .contact-table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><?php echo SITE_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="contact-list.php">Contact List <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="text-center">Contact List</h1>
            <p class="text-center">View all contacts submitted through our contact form.</p>
        </div>
    </header>
    
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-12">
                <!-- Add this before the contact-table div -->
                <div class="mb-4">
                    <form action="contact-list.php" method="GET" class="form-inline justify-content-center">
                        <div class="input-group w-50">
                            <input type="text" name="search" class="form-control" placeholder="Search contacts..." 
                                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="contact-table">
                    <?php if (count($contacts) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Location</th>
                                        <th>Date Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact): ?>
                                        <tr>
                                            <td><?php echo $contact['rowid']; ?></td>
                                            <td>
                                                <?php 
                                                $firstname = isset($contact['firstname']) ? $contact['firstname'] : 
                                                            (isset($contact['first_name']) ? $contact['first_name'] : '');
                                                $lastname = isset($contact['lastname']) ? $contact['lastname'] : 
                                                           (isset($contact['last_name']) ? $contact['last_name'] : 
                                                           (isset($contact['name']) ? $contact['name'] : ''));
                                                echo htmlspecialchars($firstname . ' ' . $lastname); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $email = isset($contact['email']) ? $contact['email'] : 
                                                        (isset($contact['email_address']) ? $contact['email_address'] : '');
                                                echo htmlspecialchars($email); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $phone = isset($contact['phone']) ? $contact['phone'] : 
                                                        (isset($contact['phone_pro']) ? $contact['phone_pro'] : 
                                                        (isset($contact['telephone']) ? $contact['telephone'] : ''));
                                                echo htmlspecialchars($phone); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $town = isset($contact['town']) ? $contact['town'] : 
                                                       (isset($contact['city']) ? $contact['city'] : '');
                                                echo htmlspecialchars($town); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $date = isset($contact['datec']) ? $contact['datec'] : 
                                                       (isset($contact['date_creation']) ? $contact['date_creation'] : '');
                                                echo $date ? date('Y-m-d', strtotime($date)) : 'N/A'; 
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info m-3">
                            <i class="fas fa-info-circle"></i> No contacts found in the database.
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="contact.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add New Contact
                    </a>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>We provide high-quality products and exceptional customer service. Our mission is to make your shopping experience enjoyable and hassle-free.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Home</a></li>
                        <li><a href="products.php" class="text-white">Products</a></li>
                        <li><a href="about.php" class="text-white">About Us</a></li>
                        <li><a href="contact.php" class="text-white">Contact</a></li>
                        <li><a href="contact-list.php" class="text-white">Contact List</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <address>
                        <p class="mb-1"><i class="fas fa-map-marker-alt mr-2"></i> 123 Business Street, City, State 12345</p>
                        <p class="mb-1"><i class="fas fa-phone mr-2"></i> +1 (123) 456-7890</p>
                        <p class="mb-1"><i class="fas fa-envelope mr-2"></i> info@example.com</p>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <hr class="bg-light">
                    <p class="m-0">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    // After the table but before the buttons
    <?php if (count($contacts) == 50): ?>
        <div class="mt-3 text-center">
            <p class="text-muted">Showing first 50 contacts. Implement pagination for more.</p>
        </div>
    <?php endif; ?>
</body>
</html>