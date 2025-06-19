<?php require_once 'app/views/containers/header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h1>Login</h1>
            
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
            
            <form action="<?= BASE_URL ?>?page=auth&action=login" method="post" class="auth-form">
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                
                <div class="auth-links">
                    <p><a href="<?= BASE_URL ?>?page=auth&action=forgot-password">Forgot Password?</a></p>
                    <p>Don't have an account? <a href="<?= BASE_URL ?>?page=auth&action=register">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once 'app/views/containers/footer.php'; ?>