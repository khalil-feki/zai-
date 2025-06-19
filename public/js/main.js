// Add this to your main.js file or create it if it doesn't exist
document.addEventListener('DOMContentLoaded', function() {
    // Set global AJAX timeout
    if (window.XMLHttpRequest) {
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function() {
            this.timeout = 10000; // 10 seconds timeout
            originalOpen.apply(this, arguments);
        };
    }
    
    // Performance optimization: Debounce scroll and resize events
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    // Handle scroll events efficiently
    const scrollHandler = debounce(function() {
        // Your scroll handling code here
    }, 100);
    
    window.addEventListener('scroll', scrollHandler);
    
    // Fix for image loading issues
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            if (!this.src.includes('default-product.jpg')) {
                this.src = BASE_URL + 'public/img/products/default-product.jpg';
            }
        });
        
        // Force reload images that might be stuck
        if (img.complete && img.naturalHeight === 0) {
            img.src = img.src;
        }
    });
    
    // Stop any potential infinite animations
    setTimeout(function() {
        const animations = document.querySelectorAll('*');
        animations.forEach(function(element) {
            const computedStyle = window.getComputedStyle(element);
            if (computedStyle.animationName !== 'none' && computedStyle.animationIterationCount === 'infinite') {
                element.style.animationIterationCount = '1';
            }
        });
    }, 5000); // After 5 seconds, stop any infinite animations
    
    // Fix for potential memory leaks
    window.addEventListener('beforeunload', function() {
        // Remove event listeners when navigating away
        window.removeEventListener('scroll', scrollHandler);
    });
    
    // Check for and stop any runaway processes
    let lastTime = Date.now();
    let frames = 0;
    
    // Disable performance monitoring in production
    const isProduction = window.location.hostname !== 'localhost' && 
                         window.location.hostname !== '127.0.0.1';
    
    if (!isProduction) {
        function checkPerformance() {
            frames++;
            const currentTime = Date.now();
            
            if (currentTime - lastTime >= 1000) {
                const fps = frames;
                frames = 0;
                lastTime = currentTime;
                
                // If FPS is too high, something might be causing excessive repaints
                if (fps > 100) {
                    console.warn('High refresh rate detected. Checking for performance issues...');
                    
                    // Force a layout recalculation to stop any layout thrashing
                    document.body.style.display = 'none';
                    void document.body.offsetHeight; // Force reflow
                    document.body.style.display = '';
                }
            }
            
            requestAnimationFrame(checkPerformance);
        }
        
        requestAnimationFrame(checkPerformance);
    }
});