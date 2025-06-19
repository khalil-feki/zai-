// Animation Enhancement Script

document.addEventListener('DOMContentLoaded', function() {
    // Scroll reveal animations
    const fadeElements = document.querySelectorAll('.fade-in-up');
    const staggerItems = document.querySelectorAll('.stagger-item');
    
    // Set stagger item indices for CSS delay calculation
    staggerItems.forEach((item, index) => {
        item.style.setProperty('--item-index', index);
    });
    
    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    // Observe all fade elements
    fadeElements.forEach(el => {
        observer.observe(el);
    });
    
    // Parallax scrolling effect
    window.addEventListener('scroll', function() {
        const parallaxElements = document.querySelectorAll('.asm-parallax');
        const scrollPosition = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            element.style.transform = `translateY(${scrollPosition * speed}px)`;
        });
    });
    
    // Add hover effects for feature cards
    const featureCards = document.querySelectorAll('.feature-card, .asm-feature-card');
    
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('hover');
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('hover');
        });
    });
    
    // Animated counter for statistics
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Start counter animation when element is in view
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        counterObserver.observe(counter);
    });
    
    // Typing animation effect
    const typingElements = document.querySelectorAll('.typing');
    
    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        element.style.width = '0';
        
        let charIndex = 0;
        const typeChar = () => {
            if (charIndex < text.length) {
                element.textContent += text.charAt(charIndex);
                charIndex++;
                setTimeout(typeChar, 100);
            }
        };
        
        const typingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        typeChar();
                    }, 500);
                    typingObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        typingObserver.observe(element);
    });
    
    // Add shine effect on CTA buttons
    const ctaButtons = document.querySelectorAll('.asm-btn, .btn-primary');
    
    ctaButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.classList.add('shine');
        });
        
        button.addEventListener('mouseleave', function() {
            this.classList.remove('shine');
        });
    });
    
    // Animate map points
    const mapPoints = document.querySelectorAll('.asm-map-point');
    let activePoint = null;
    
    mapPoints.forEach(point => {
        // Random animation delay for natural effect
        const delay = Math.random() * 2;
        point.style.animationDelay = `${delay}s`;
        
        point.addEventListener('click', function() {
            if (activePoint) {
                activePoint.classList.remove('active');
            }
            this.classList.add('active');
            activePoint = this;
        });
    });
    
    // Add cart animation
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            this.classList.add('adding');
            
            setTimeout(() => {
                this.classList.remove('adding');
                this.classList.add('added');
                
                // Update cart count
                const cartBadge = document.querySelector('.cart-badge');
                if (cartBadge) {
                    const currentCount = parseInt(cartBadge.textContent);
                    cartBadge.textContent = currentCount + 1;
                    cartBadge.classList.add('shake');
                    
                    setTimeout(() => {
                        cartBadge.classList.remove('shake');
                    }, 800);
                }
            }, 800);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('.scroll-btn').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Set stagger delays for elements
    document.querySelectorAll('.stagger-item').forEach((el, index) => {
        el.style.setProperty('--item-index', index);
    });
    
    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });
    
    // Parallax effect for background sections
    window.addEventListener('scroll', function() {
        const parallaxElements = document.querySelectorAll('.asm-parallax');
        parallaxElements.forEach(element => {
            const scrollPosition = window.pageYOffset;
            const speed = element.getAttribute('data-speed') || 0.5;
            element.style.backgroundPositionY = `${scrollPosition * speed}px`;
        });
    });
    
    // Add hover effect for map points
    document.querySelectorAll('.asm-map-point').forEach(point => {
        point.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'map-tooltip';
            tooltip.textContent = this.getAttribute('data-location');
            tooltip.style.position = 'absolute';
            tooltip.style.top = '-40px';
            tooltip.style.left = '50%';
            tooltip.style.transform = 'translateX(-50%)';
            tooltip.style.backgroundColor = '#fff';
            tooltip.style.color = '#333';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '5px';
            tooltip.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            tooltip.style.zIndex = '100';
            tooltip.style.whiteSpace = 'nowrap';
            this.appendChild(tooltip);
        });
        
        point.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.map-tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
});
