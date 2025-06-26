// Solution icons interaction functionality
document.addEventListener('DOMContentLoaded', function() {
    const icons = document.querySelectorAll('.solution-item-icon');
    const features = document.querySelectorAll('.solution-feature');
    
    // Set first feature as active by default
    if (features.length > 0) {
        features[0].classList.add('active');
        icons[0].classList.add('active');
    }
    
    icons.forEach((icon, index) => {
        icon.addEventListener('click', function() {
            // Remove active class from all icons and features
            icons.forEach(i => i.classList.remove('active'));
            features.forEach(f => f.classList.remove('active'));
            
            // Add active class to clicked icon
            this.classList.add('active');
            
            // Get the feature name from data attribute
            const featureName = this.getAttribute('data-feature');
            const targetFeature = document.getElementById(`feature-${featureName}`);
            
            if (targetFeature) {
                targetFeature.classList.add('active');
            }
        });
        
        // Add hover effects
        icon.addEventListener('mouseenter', function() {
            const featureName = this.getAttribute('data-feature');
            const targetFeature = document.getElementById(`feature-${featureName}`);
            
            if (targetFeature && !targetFeature.classList.contains('active')) {
                targetFeature.style.opacity = '0.9';
                targetFeature.style.transform += ' scale(1.05)';
            }
        });
        
        icon.addEventListener('mouseleave', function() {
            const featureName = this.getAttribute('data-feature');
            const targetFeature = document.getElementById(`feature-${featureName}`);
            
            if (targetFeature && !targetFeature.classList.contains('active')) {
                targetFeature.style.opacity = '0.7';
                targetFeature.style.transform = targetFeature.style.transform.replace(' scale(1.05)', '');
            }
        });
    });
    
    // Auto-rotate through features every 5 seconds
    let currentIndex = 0;
    setInterval(() => {
        if (icons.length > 0) {
            // Remove active from current
            icons[currentIndex].classList.remove('active');
            features[currentIndex].classList.remove('active');
            
            // Move to next
            currentIndex = (currentIndex + 1) % icons.length;
            
            // Add active to next
            icons[currentIndex].classList.add('active');
            features[currentIndex].classList.add('active');
        }
    }, 5000);
});