<?php require_once 'app/views/containers/header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h1>Forgot Password</h1>
            <p class="auth-intro">Enter your email address and we'll send you a link to reset your password.</p>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>?page=auth&action=forgot-password" method="post" class="auth-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                </div>
                
                <div class="auth-links">
                    <p>Remember your password? <a href="<?= BASE_URL ?>?page=auth&action=login">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'app/views/containers/footer.php'; ?>