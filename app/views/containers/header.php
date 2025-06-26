<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= SITE_NAME ?></title>
    <script>
        // Define BASE_URL for JavaScript
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/products.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/auth.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/profile.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
    window.addEventListener('error', function(e) {
        console.error('JavaScript error:', e.message, 'at', e.filename, 'line', e.lineno);
    });
    </script>
    <!-- Enhanced styling for a modern look -->
    <style>
        :root {
            --primary-color: #4a6cf7;
            --primary-dark: #3a5ce5;
            --secondary-color: #6c757d;
            --accent-color: #ff6b6b;
            --success-color: #20c997;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --card-bg: #ffffff;
            --card-shadow: 0 10px 30px rgba(0,0,0,0.08);
            --transition-fast: 0.3s;
            --transition-medium: 0.5s;
            --transition-slow: 0.8s;
            --border-radius: 8px;
        }
        
        body {
            background-color: var(--light-bg);
            background-image: linear-gradient(to bottom, #f8f9fa, #ffffff);
            background-attachment: fixed;
        }
        
        /* Enhanced card styling with glass morphism effect */
        .card {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), 
                        box-shadow 0.3s ease;
            border: none;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
        }
        
        /* Product image container with subtle zoom effect */
        .product-image-container {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f9f9f9;
            position: relative;
        }
        
        .product-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(74, 108, 247, 0.05) 0%, rgba(255, 255, 255, 0) 50%);
            z-index: 1;
        }
        
        .product-image-container img {
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }
        
        .card:hover .product-image-container img {
            transform: scale(1.08);
        }
        
        /* Enhanced buttons with gradient and animation */
        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: height 0.3s ease;
            z-index: -1;
        }
        
        .btn:hover::after {
            height: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            border: none;
            box-shadow: 0 4px 15px rgba(74, 108, 247, 0.3);
            color: white;
        }
        
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(74, 108, 247, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }
        
        .btn-success:hover {
            background: linear-gradient(45deg, #218838, #1ca38b);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            transform: translateY(-2px);
        }
        
        /* Modern contact page styling */
        .contact-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
        }
        
        .contact-header {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }
        
        .contact-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }
        
        .contact-header h1 {
            font-size: 2.8rem;
            color: var(--text-color);
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .contact-header p {
            color: var(--secondary-color);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .contact-content {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
        }
        
        .contact-info {
            flex: 1;
            min-width: 300px;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 35px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .contact-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        }
        
        .contact-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .contact-form-container {
            flex: 2;
            min-width: 300px;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 35px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .contact-form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--accent-color), var(--primary-color));
        }
        
        .contact-form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .contact-info h3, .contact-form-container h3 {
            color: var(--text-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
            position: relative;
        }
        
        .contact-info h3::after, .contact-form-container h3::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        }
        
        .contact-info p {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }
        
        .contact-info i {
            color: var(--primary-color);
            margin-right: 15px;
            font-size: 20px;
            width: 25px;
            margin-top: 3px;
        }
        
        .contact-form .form-group {
            margin-bottom: 25px;
        }
        
        .contact-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        
        .contact-form input:focus, .contact-form textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
            outline: none;
            background-color: #fff;
        }
        
        .contact-form textarea {
            min-height: 180px;
            resize: vertical;
        }
        
        .contact-form button {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 108, 247, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .contact-form button:hover {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
            box-shadow: 0 6px 20px rgba(74, 108, 247, 0.4);
            transform: translateY(-2px);
        }
        
        /* Modern social icons with hover effects */
        .social-icons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        
        .social-icons a {
            color: var(--primary-color);
            font-size: 24px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: rgba(74, 108, 247, 0.1);
        }
        
        .social-icons a:hover {
            color: white;
            background-color: var(--primary-color);
            transform: translateY(-3px) rotate(8deg);
            box-shadow: 0 5px 15px rgba(74, 108, 247, 0.3);
        }
        
        .map-container {
            margin-top: 50px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .map-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .map-container iframe {
            width: 100%;
            height: 450px;
            border: 0;
        }
        
        /* Modern alert styling with animation */
        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            position: relative;
            border-left: 4px solid;
            animation: slideIn 0.5s ease forwards;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background-color: rgba(32, 201, 151, 0.1);
            border-left-color: var(--success-color);
            color: #0f6848;
        }
        
        .alert-error {
            background-color: rgba(255, 107, 107, 0.1);
            border-left-color: var(--accent-color);
            color: #a83232;
        }
        
        /* Responsive design improvements */
        @media (max-width: 768px) {
            .contact-content {
                flex-direction: column;
            }
            
            .contact-info, .contact-form-container {
                width: 100%;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0 !important;
            }
            
            .contact-header h1 {
                font-size: 2.2rem;
            }
        }
        
        /* Navbar enhancements */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .nav-links a {
            position: relative;
            overflow: hidden;
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        /* Cart badge animation */
        .cart-badge {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 107, 107, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 107, 107, 0);
            }
        }
    </style>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/animations.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/category-menu.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>public/img/logo.jpeg" alt="Logo">
                </a>
            </div>
            
            <button class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <ul class="nav-links">
                <li><a href="<?= BASE_URL ?>">Home</a></li>
                <!-- Products dropdown removed -->
                <li class="has-dropdown">
                    <a href="<?= BASE_URL ?>category">Categories</a>
                    <ul class="dropdown">
                        <?php
                        // Load categories for the dropdown (only those with products)
                        require_once 'app/models/Category.php';
                        $categoryModel = new Category();
                        $navCategories = $categoryModel->getCategoriesWithProducts();
                        
                        if (!empty($navCategories)) {
                            foreach ($navCategories as $navCategory) {
                                echo '<li><a href="' . BASE_URL . 'category/view/' . $navCategory['rowid'] . '">' . htmlspecialchars($navCategory['label']) . '</a></li>';
                            }
                        }
                        ?>
                        <li><a href="<?= BASE_URL ?>category">All Categories</a></li>
                    </ul>
                </li>
                
                <?php if (isLoggedIn()): ?>
                    <!-- Add this to your navigation bar -->
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>tickets">Support Tickets</a>
                </li>
                    <li><a href="<?= BASE_URL ?>orders">Orders</a></li>
                    <li class="has-dropdown">
                        <a href="<?= BASE_URL ?>user/profile">
                            <i class="fas fa-user"></i> <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Profile' ?>
                        </a>
                        <ul class="dropdown">
                            <li><a href="<?= BASE_URL ?>user/profile">My Profile</a></li>
                            <li><a href="<?= BASE_URL ?>orders">My Orders</a></li>
                            <li><a href="<?= BASE_URL ?>auth/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>auth/login">Login</a></li>
                    <li><a href="<?= BASE_URL ?>auth/register">Register</a></li>
                <?php endif; ?>
            </ul>
            
            <!-- Cart icon moved to the right -->
            <?php if (isLoggedIn()): ?>
            <div class="cart-icon-wrapper">
                <a href="<?= BASE_URL ?>index.php?page=cart" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="cart-badge"><?= count($_SESSION['cart']) ?></span>
                    <?php endif; ?>
                </a>
            </div>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>        <?php endif; ?>
