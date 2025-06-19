<?php require_once 'app/views/containers/header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h1>Reset Password</h1>
            <p class="auth-intro">Enter your new password below.</p>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error']; ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>?page=auth&action=reset-password" method="post" class="auth-form">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
                
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                    <small>Password must be at least 6 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
                
                <div class="auth-links">
                    <p>Remember your password? <a href="<?= BASE_URL ?>?page=auth&action=login">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'app/views/containers/footer.php'; ?>