<?php require_once 'app/views/containers/header.php'; ?>

<div class="auth-section">
    <div class="auth-container">
        <h1>My Addresses</h1>
        
        <!-- Profile Navigation -->
        <div class="profile-menu">
            <ul>
                <li><a href="<?= BASE_URL ?>user/profile">Profile Information</a></li>
                <li class="active"><a href="<?= BASE_URL ?>user/addresses">My Addresses</a></li>
                
                <li><a href="<?= BASE_URL ?>auth/logout">Logout</a></li>
            </ul>
        </div>
        
        <div class="auth-form">
            <div class="addresses-header">
                <h2>Manage Your Addresses</h2>
                <button class="btn btn-primary" id="add-address-btn">
                    <i class="fas fa-plus"></i> Add New Address
                </button>
            </div>
                
            <div class="addresses-content">
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
                <form action="<?= BASE_URL ?>index.php?page=user&action=saveAddress" method="post">
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
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('address-modal').style.display='none'">Cancel</button>
                    </div>
                </form>
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
/* Modern Addresses Page Styling */
.auth-container {
    max-width: 900px !important;
}

.addresses-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.addresses-header h2 {
    margin: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.8rem;
    font-weight: 700;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.2);
}

.btn-secondary:hover {
    background: rgba(108, 117, 125, 0.2);
    transform: translateY(-1px);
}

.btn-small {
    padding: 8px 16px;
    font-size: 0.85rem;
}

.btn-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
}

/* Alert Styling */
.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    border: none;
    font-weight: 500;
}

.alert-success {
    background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(81, 207, 102, 0.3);
}

.alert-error {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state p {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.8;
}

/* Addresses Grid */
.addresses-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.address-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.address-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.address-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.address-details {
    margin-bottom: 20px;
}

.address-details p {
    margin: 8px 0;
    color: #2d3748;
    font-weight: 500;
    line-height: 1.5;
}

.address-details p:first-child {
    font-weight: 600;
    color: #1a202c;
    font-size: 1.05rem;
}

.address-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 15px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

/* Modal Styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
}

.modal-content {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    margin: 5% auto;
    padding: 40px;
    border-radius: 24px;
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-content h2 {
    margin: 0 0 30px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.6rem;
    font-weight: 700;
    text-align: center;
}

.close {
    position: absolute;
    right: 20px;
    top: 15px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #6c757d;
    transition: all 0.3s ease;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(108, 117, 125, 0.1);
}

.close:hover {
    color: #ff6b6b;
    background: rgba(255, 107, 107, 0.1);
    transform: rotate(90deg);
}

/* Form Styling */
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2d3748;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-control {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid rgba(102, 126, 234, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .auth-container {
        max-width: 100% !important;
        padding: 10px;
    }
    
    .addresses-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .addresses-list {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .modal-content {
        margin: 10% auto;
        padding: 30px 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .address-actions {
        justify-content: center;
    }
}
</style>

<?php require_once 'app/views/containers/footer.php'; ?>