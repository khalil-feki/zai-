<?php require_once 'app/views/containers/header.php'; ?>

<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <h1>My Profile</h1>
            
            <div class="profile-menu">
                <ul>
                    <li class="active"><a href="<?= BASE_URL ?>user/profile">Profile Information</a></li>
                    <li><a href="<?= BASE_URL ?>user/addresses">My Addresses</a></li>
                    <li><a href="<?= BASE_URL ?>auth/logout">Logout</a></li>
                </ul>
            </div>
        
            <div class="auth-form">
                <h2>Profile Information</h2>
                
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
                
                <form action="<?= BASE_URL ?>user/update" method="POST" class="profile-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($user['firstname'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                    </div>
                    
                    <h3>Change Password</h3>
                    <p class="form-note">Leave blank if you don't want to change your password</p>
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password">
                            <small>Minimum 6 characters</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success'] ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?= $_SESSION['error'] ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'app/views/containers/footer.php'; ?>