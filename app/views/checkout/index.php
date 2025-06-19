<?php
require_once 'app/views/containers/header.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>public/css/checkout.css">

<div class="checkout-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card checkout-card">
                <div class="card-header">
                    <h4>Checkout</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error_message']) ?>
                            <?php unset($_SESSION['error_message']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success_message']) ?>
                            <?php unset($_SESSION['success_message']); ?>
                        </div>
                    <?php endif; ?>

                    <form id="checkout-form" action="<?= BASE_URL ?>checkout/process" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Shipping Address</h5>
                                <div class="form-group">
                                    <label for="shipping_address">Address *</label>
                                    <textarea id="shipping_address" name="shipping_address" class="form-control" rows="3" required placeholder="Enter your shipping address"></textarea>
                                    <div class="invalid-feedback">Please provide a shipping address.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Billing Address</h5>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="same_as_shipping" checked>
                                        <label class="form-check-label" for="same_as_shipping">
                                            Same as shipping address
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="billing_address">Address</label>
                                    <textarea id="billing_address" name="billing_address" class="form-control" rows="3" placeholder="Enter billing address if different"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>Payment Method</h5>
                                <div class="form-group">
                                    <label for="payment_method">Payment Method *</label>
                                    <select id="payment_method" name="payment_method" class="form-control" required>
                                        <option value="">Select payment method</option>
                                        <option value="cash_on_delivery">Cash on Delivery</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="credit_card">Credit Card</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a payment method.</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Order Notes</h5>
                                <div class="form-group">
                                    <label for="notes">Special Instructions</label>
                                    <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="Any special instructions for your order"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions mt-4 d-flex justify-content-between align-items-center">
                            <a href="<?= BASE_URL ?>cart" class="btn btn-secondary">Back to Cart</a>
                            <button type="submit" id="place-order-btn" class="btn btn-primary">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card checkout-card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body order-summary">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="summary-item">
                                <span><?= htmlspecialchars($item['label']) ?> x <?= $item['quantity'] ?></span>
                                <span><?= number_format($item['price'] * $item['quantity'], 2) ?> TND</span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Total:</span>
                            <span><?= number_format($cartTotal, 2) ?> TND</span>
                        </div>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced form handling
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
    const shippingAddress = document.getElementById('shipping_address');
    const billingAddress = document.getElementById('billing_address');
    
    console.log('Checkout form initialized');
    console.log('Form action:', form.action);
    console.log('BASE_URL:', '<?= BASE_URL ?>');
    
    // Handle same as shipping checkbox
    sameAsShippingCheckbox.addEventListener('change', function() {
        if (this.checked) {
            billingAddress.value = shippingAddress.value;
            billingAddress.disabled = true;
        } else {
            billingAddress.disabled = false;
        }
    });
    
    // Update billing address when shipping address changes
    shippingAddress.addEventListener('input', function() {
        if (sameAsShippingCheckbox.checked) {
            billingAddress.value = this.value;
        }
    });
    
    // Form submission handling
    form.addEventListener('submit', function(e) {
        console.log('Form submission started');
        
        // Disable submit button to prevent double submission
        placeOrderBtn.disabled = true;
        placeOrderBtn.innerHTML = 'Processing...';
        
        // Basic validation
        const shippingAddr = shippingAddress.value.trim();
        const paymentMethod = document.getElementById('payment_method').value;
        
        console.log('Shipping address:', shippingAddr);
        console.log('Payment method:', paymentMethod);
        
        if (!shippingAddr) {
            e.preventDefault();
            alert('Please enter a shipping address.');
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = 'Place Order';
            return false;
        }
        
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method.');
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = 'Place Order';
            return false;
        }
        
        console.log('Form validation passed, submitting...');
        
        // Set billing address if same as shipping
        if (sameAsShippingCheckbox.checked) {
            billingAddress.value = shippingAddr;
        }
        
        // Allow form to submit
        return true;
    });
    
    // Debug user session
    <?php if (isset($_SESSION['user_id'])): ?>
    console.log('User logged in with ID:', <?= $_SESSION['user_id'] ?>);
    <?php else: ?>
    console.error('ERROR: User not logged in!');
    alert('You must be logged in to place an order.');
    window.location.href = '<?= BASE_URL ?>login';
    <?php endif; ?>
});
</script>

<?php require_once 'app/views/containers/footer.php'; ?>