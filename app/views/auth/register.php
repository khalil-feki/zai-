<?php require_once 'app/views/containers/header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h1>Register</h1>
        
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
        
            <form action="<?= BASE_URL ?>?page=auth&action=register" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <small>Password must be at least 6 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            
            <div class="auth-links">
                <p>Already have an account? <a href="<?= BASE_URL ?>?page=auth&action=login">Login</a></p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/containers/footer.php'; ?>