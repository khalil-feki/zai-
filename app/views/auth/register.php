<?php require_once 'app/views/containers/header.php'; ?>

<div class="auth-container">
    <div class="auth-form">
        <h2>Register</h2>
        
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
        
        <form action="<?= BASE_URL ?>?page=auth&action=register" method="POST">
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
            
            <!-- Add these fields to your registration form -->
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="zip">Postal Code</label>
                    <input type="text" name="zip" id="zip" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="town">City</label>
                    <input type="text" name="town" id="town" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="mobile">Mobile</label>
                    <input type="text" name="mobile" id="mobile" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="country_id">Country</label>
                <select name="country_id" id="country_id" class="form-control">
                    <option value="1">France</option>
                    <option value="2">Belgium</option>
                    <option value="3">Luxembourg</option>
                    <option value="4">Switzerland</option>
                    <option value="5">Spain</option>
                    <option value="6">Italy</option>
                    <option value="7">Germany</option>
                    <option value="11">United States</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <div class="auth-links">
            <p>Already have an account? <a href="<?= BASE_URL ?>?page=auth&action=login">Login</a></p>
        </div>
    </div>
</div>

<?php require_once 'app/views/containers/footer.php'; ?>