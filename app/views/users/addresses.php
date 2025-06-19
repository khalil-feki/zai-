<?php require_once 'app/views/containers/header.php'; ?>

<div class="profile-container">
    <div class="profile-header">
        <h1>My Addresses</h1>
    </div>
    
    <div class="profile-content">
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <img src="<?= BASE_URL ?>public/images/avatar.png" alt="Profile Avatar">
                <h3><?= htmlspecialchars(($user['nom'] ?? '')) ?></h3>
                <p class="user-email"><?= htmlspecialchars($user['email'] ?? 'No email available') ?></p>
            </div>
            
            <div class="profile-menu">
                <ul>
                    <li><a href="<?= BASE_URL ?>user/profile">Profile Information</a></li>
                    <li class="active"><a href="<?= BASE_URL ?>user/addresses">My Addresses</a></li>
                    <li><a href="<?= BASE_URL ?>user/orders">My Orders</a></li>
                    <li><a href="<?= BASE_URL ?>auth/logout">Logout</a></li>
                </ul>
            </div>
        </div>
        
        <div class="profile-details">
            <div class="card">
                <div class="card-header">
                    <h2>Addresses</h2>
                    <button class="btn btn-primary" id="add-address-btn">Add New Address</button>
                </div>
                
                <div class="card-body">
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
                    
                    <?php if (empty($addresses)): ?>
                        <div class="empty-state">
                            <p>You don't have any saved addresses yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="addresses-list">
                            <?php foreach ($addresses as $address): ?>
                                <div class="address-card">
                                    <div class="address-details">
                                        <p><?= htmlspecialchars($address['address'] ?? 'No street address') ?></p>
                                        <p><?= htmlspecialchars(($address['zip'] ?? '') . ' ' . ($address['town'] ?? '')) ?></p>
                                        <p><?= htmlspecialchars($address['country_id'] ?? '') ?></p>
                                    </div>
                                    <div class="address-actions">
                                        <button class="btn btn-small edit-address" data-id="<?= $address['rowid'] ?>">Edit</button>
                                        <button class="btn btn-small btn-danger delete-address" data-id="<?= $address['rowid'] ?>">Delete</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Address Form Modal (Hidden by default) -->
            <div id="address-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add/Edit Address</h2>
                    <form action="<?= BASE_URL ?>user/saveAddress" method="post">
                        <input type="hidden" name="address_id" id="address_id" value="">
                        
                        <div class="form-group">
                            <label for="address">Street Address</label>
                            <input type="text" id="address" name="address" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="zip">Postal Code</label>
                            <input type="text" id="zip" name="zip" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="town">City</label>
                            <input type="text" id="town" name="town" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="country_id">Country</label>
                            <select id="country_id" name="country_id" class="form-control">
                                <option value="">Select Country</option>
                                <!-- You can populate this with actual country data -->
                                <option value="1">France</option>
                                <option value="2">United States</option>
                                <option value="3">United Kingdom</option>
                                <option value="4">Germany</option>
                                <option value="5">Spain</option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('address-modal');
    const addBtn = document.getElementById('add-address-btn');
    const closeBtn = document.querySelector('.close');
    const editBtns = document.querySelectorAll('.edit-address');
    
    // Open modal on add button click
    addBtn.addEventListener('click', function() {
        // Clear form for new address
        document.getElementById('address_id').value = '';
        document.getElementById('address').value = '';
        document.getElementById('zip').value = '';
        document.getElementById('town').value = '';
        document.getElementById('country_id').value = '';
        
        modal.style.display = 'block';
    });
    
    // Close modal on X click
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Edit address functionality
    editBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const addressId = this.getAttribute('data-id');
            // You would typically fetch the address details via AJAX here
            // For now, we'll just open the modal with empty fields
            document.getElementById('address_id').value = addressId;
            modal.style.display = 'block';
        });
    });
});
</script>

<style>
.addresses-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.address-card {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.address-details {
    margin-bottom: 15px;
}

.address-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 5px;
    width: 50%;
    max-width: 500px;
    position: relative;
}

.close {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.empty-state {
    text-align: center;
    padding: 30px;
    color: #666;
}
</style>

<?php require_once 'app/views/containers/footer.php'; ?>