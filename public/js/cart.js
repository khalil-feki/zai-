document.addEventListener('DOMContentLoaded', function() {
    // Handle add to cart forms
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    // Handle form submissions
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            submitBtn.disabled = true;
            
            console.log('Adding to cart:', Object.fromEntries(formData));
            
            fetch(BASE_URL + 'index.php?page=cart&action=add', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    showMessage('success', data.message);
                    updateCartCount(data.cart_count);
                    
                    // Reset form
                    const quantityInput = this.querySelector('input[name="quantity"]');
                    if (quantityInput) {
                        quantityInput.value = 1;
                    }
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                showMessage('error', 'An error occurred: ' + (error.message || 'Please try again.'));
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    });
    
    // Handle button clicks (for buttons without forms)
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            if (!productId) {
                showMessage('error', 'Product ID not found');
                return;
            }
            
            const originalText = this.innerHTML;
            
            // Show loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;
            
            const requestData = { product_id: productId, quantity: 1 };
            console.log('Adding to cart:', requestData);
            
            fetch(BASE_URL + 'index.php?page=cart&action=add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    showMessage('success', data.message);
                    updateCartCount(data.cart_count);
                    
                    // Add success animation
                    this.classList.add('btn-success');
                    this.innerHTML = '<i class="fas fa-check"></i> Added!';
                    
                    setTimeout(() => {
                        this.classList.remove('btn-success');
                        this.innerHTML = originalText;
                    }, 2000);
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred. Please try again.');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });
    
    // Quantity controls
    const quantityControls = document.querySelectorAll('.quantity-controls');
    quantityControls.forEach(control => {
        const decreaseBtn = control.querySelector('.quantity-decrease');
        const increaseBtn = control.querySelector('.quantity-increase');
        const input = control.querySelector('.quantity-input');
        
        if (decreaseBtn && input) {
            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value) || 1;
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
        }
        
        if (increaseBtn && input) {
            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value) || 1;
                const maxValue = parseInt(input.getAttribute('max')) || 99;
                if (currentValue < maxValue) {
                    input.value = currentValue + 1;
                }
            });
        }
    });
    
    // Auto-update cart when quantity changes
    const cartQuantityInputs = document.querySelectorAll('.cart-quantity-input');
    cartQuantityInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const form = this.closest('form');
                if (form) {
                    form.submit();
                }
            }, 1000); // Wait 1 second after user stops typing
        });
    });
});

/**
 * Show message to user
 */
function showMessage(type, message) {
    // Remove existing messages
    const existingMessages = document.querySelectorAll('.cart-message');
    existingMessages.forEach(msg => msg.remove());
    
    // Create new message
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show cart-message`;
    messageDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at top of page
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(messageDiv, container.firstChild);
    }
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 5000);
}

/**
 * Update cart count in header
 */
function updateCartCount(count) {
    const cartBadge = document.querySelector('.cart-badge');
    const cartIcon = document.querySelector('.cart-icon');
    
    if (cartBadge) {
        cartBadge.textContent = count;
        cartBadge.style.display = count > 0 ? 'inline-block' : 'none';
    } else if (cartIcon && count > 0) {
        // Create badge if it doesn't exist
        const badge = document.createElement('span');
        badge.className = 'cart-badge';
        badge.textContent = count;
        cartIcon.appendChild(badge);
    }
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return '€' + parseFloat(amount).toFixed(2);
}