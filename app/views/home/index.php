<?php require_once 'app/views/containers/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="public/css/cta-section.css">
<link rel="stylesheet" href="public/css/team-section.css">
<section class="hero-section">
  <div class="hero-container">
    <div class="hero-content">
      <h1 class="hero-title">Votre partenaire <span class="highlight">LOGICIEL</span> de caisse!</h1>
      <p class="hero-description">Logiciel de caisse pour gérer efficacement votre commerce. Solution complète pour les restaurants, commerces de détail et services.</p>
      <div class="hero-buttons">
        <a href="<?= BASE_URL ?>?page=auth&action=register" class="hero-btn hero-btn-primary">Demander une démo</a>
        <a href="#solution-selection" class="hero-btn hero-btn-secondary scroll-btn">Découvrir nos solutions</a>
      </div>
    </div>
    <div class="hero-image">
      <img src="<?= BASE_URL ?>public/images/pos-system.png" alt="Système POS">
    </div>
  </div>
  
  <!-- Decorative shapes -->
  <div class="hero-shape hero-shape-1"></div>
  <div class="hero-shape hero-shape-2"></div>
  <div class="hero-shape hero-shape-3"></div>
  <div class="hero-shape hero-shape-4"></div>
  
  <!-- Optional badge -->
  <div class="hero-badge">
    <span class="badge-text">Nouveau</span>
    <span class="badge-subtext">2025</span>
  </div>
</section>

<section id="solution-selection" class="solution-selection-section">
    <div class="solution-selection-container">
        <div class="solution-selection-title animate-fadeIn">
            <h2>Choisissez votre solution</h2>
            <p>Découvrez les fonctionnalités qui font la différence pour votre entreprise</p>
        </div>
        
        <div class="solution-selection-content">
            <div class="solution-connection"></div>
            
            <div class="solution-center">
                <img src="<?= BASE_URL ?>public/images/logo-pos.png" alt="Logo POS">
            </div>
            
            <div class="solution-items stagger-list">
                <div class="solution-item">
                    <div class="solution-item-icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <h3>Ventes</h3>
                    <p>Gérez vos transactions rapidement avec une interface intuitive et efficace.</p>
                </div>
                
                <div class="solution-item">
                    <div class="solution-item-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h3>Inventaire</h3>
                    <p>Suivez votre stock en temps réel et recevez des alertes automatiques.</p>
                </div>
                
                <div class="solution-item">
                    <div class="solution-item-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Clients</h3>
                    <p>Créez des profils clients et développez votre programme de fidélité.</p>
                </div>
                
                <div class="solution-item">
                    <div class="solution-item-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Rapports</h3>
                    <p>Analysez vos performances avec des rapports détaillés et personnalisables.</p>
                </div>
                
                <div class="solution-item">
                    <div class="solution-item-icon">
                        <i class="fas fa-cloud"></i>
                    </div>
                    <h3>Cloud</h3>
                    <p>Vos données sont sécurisées et accessibles à tout moment dans le cloud.</p>
                </div>
                
                <div class="solution-item">
                    <div class="solution-item-icon">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h3>Intégrations</h3>
                    <p>Connectez facilement votre système avec vos outils existants.</p>
                </div>
            </div>
        </div>
    </div>
</section>

        
       

<section class="asm-cta-section">
    <div class="container">
        <div class="asm-cta-content">
            <h2>Prêt à transformer votre entreprise?</h2>
            <p>Rejoignez des milliers d'entreprises qui font confiance à notre système POS pour gérer efficacement leurs opérations quotidiennes.</p>
            <a href="<?= BASE_URL ?>?page=auth&action=register" class="asm-btn">Demander une démo</a>
        </div>
    </div>
    <div class="asm-cta-shape asm-cta-shape-1"></div>
    <div class="asm-cta-shape asm-cta-shape-2"></div>
</section>

<section class="asm-team-section">
    <div class="container">
        <div class="asm-section-title">
            <h2>Notre équipe à votre service</h2>
            <p>Des experts passionnés prêts à vous accompagner</p>
        </div>
        
        <div class="asm-team-grid">
            <div class="asm-team-member">
                <div class="asm-team-photo">
                    <img src="<?= BASE_URL ?>public/images/team-1.jpg" alt="Team Member">
                </div>
                <div class="asm-team-info">
                    <h3>Jean Dupont</h3>
                    <p>Directeur Commercial</p>
                    <div class="asm-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            <div class="asm-team-member">
                <div class="asm-team-photo">
                    <img src="<?= BASE_URL ?>public/images/team-2.jpg" alt="Team Member">
                </div>
                <div class="asm-team-info">
                    <h3>Marie Martin</h3>
                    <p>Support Technique</p>
                    <div class="asm-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            <div class="asm-team-member">
                <div class="asm-team-photo">
                    <img src="<?= BASE_URL ?>public/images/team-3.jpg" alt="Team Member">
                </div>
                <div class="asm-team-info">
                    <h3>Pierre Dubois</h3>
                    <p>Développeur</p>
                    <div class="asm-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            <div class="asm-team-member">
                <div class="asm-team-photo">
                    <img src="<?= BASE_URL ?>public/images/team-4.jpg" alt="Team Member">
                </div>
                <div class="asm-team-info">
                    <h3>Sophie Leroy</h3>
                    <p>Service Client</p>
                    <div class="asm-team-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="asm-clients-section">
    <div class="container">
        <div class="asm-section-title">
            <h2>Ils nous font confiance</h2>
            <p>Découvrez nos clients satisfaits</p>
        </div>
        
        <div class="asm-clients-grid">
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-1.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-2.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-3.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-4.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-5.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-6.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-7.jpg" alt="Client">
            </div>
            <div class="asm-client">
                <img src="<?= BASE_URL ?>public/img/client-8.jpg" alt="Client">
            </div>
        </div>
    </div>
</section>

<section class="asm-global-section">
    <div class="container">
        <div class="asm-section-title">
            <h2>zai dans le monde</h2>
            <p>Notre présence internationale</p>
        </div>
        
        <div class="asm-global-map">
            <img src="<?= BASE_URL ?>public/images/world-map.png" alt="World Map">
            <!-- Map points would be positioned absolutely -->
            <div class="asm-map-point" style="top: 30%; left: 20%;"></div>
            <div class="asm-map-point" style="top: 40%; left: 48%;"></div>
            <div class="asm-map-point" style="top: 35%; left: 70%;"></div>
            <div class="asm-map-point" style="top: 60%; left: 85%;"></div>
        </div>
    </div>
</section>




<section class="pack-selection-section">
    <div class="container">
        <div class="pack-selection-title text-center mb-5">
            <h2 class="gradient-text">Choisissez votre <span>Pack</span></h2>
            <p class="subtitle">Configurez votre solution complète selon vos besoins</p>
        </div>
        
        <div class="pack-selection-content">
            <div class="pack-center">
                <div class="pack-center-image">
                    <img src="<?= BASE_URL ?>public/images/pos-system.png" alt="Système POS" class="floating-animation">
                </div>
                <div class="pack-center-glow"></div>
            </div>
            
            <div class="pack-items-container">
                <div class="pack-items">
                    <?php
                    $packItems = [
                        [
                            'icon' => 'caisse-tactile.png',
                            'title' => 'Caisse tactile',
                            'description' => 'Sélectionnez votre Caisse Tactile'
                        ],
                        [
                            'icon' => 'logiciel.png',
                            'title' => 'Logiciel de caisse',
                            'description' => 'Sélectionnez votre Logiciel de Caisse'
                        ],
                        [
                            'icon' => 'balance.png',
                            'title' => 'Balance',
                            'description' => 'Sélectionnez votre Balance'
                        ],
                        [
                            'icon' => 'tiroir.png',
                            'title' => 'Tiroir caisse',
                            'description' => 'Sélectionnez votre Tiroir caisse'
                        ],
                        [
                            'icon' => 'lecteur.png',
                            'title' => 'Lecteurs code-barres',
                            'description' => 'Sélectionnez votre Lecteurs code-barres'
                        ],
                        [
                            'icon' => 'imprimante.png',
                            'title' => 'Imprimante',
                            'description' => 'Sélectionnez votre Imprimante'
                        ]
                    ];
                    
                    foreach ($packItems as $index => $item): 
                    ?>
                        <div class="pack-item" data-index="<?= $index ?>">
                            <div class="pack-item-inner">
                                <div class="pack-item-front">
                                    <div class="pack-item-icon">
                                        <img src="<?= BASE_URL ?>public/images/icons/<?= $item['icon'] ?>" alt="<?= $item['title'] ?>">
                                    </div>
                                    <h3><?= $item['title'] ?></h3>
                                    <p><?= $item['description'] ?></p>
                                </div>
                                <div class="pack-item-back">
                                    <h4>Options disponibles</h4>
                                    <ul class="pack-options">
                                        <li>Option Standard</li>
                                        <li>Option Premium</li>
                                        <li>Option Professionnelle</li>
                                    </ul>
                                    <button class="pack-select-btn">Sélectionner</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="pack-summary">
            <h3>Votre configuration</h3>
            <div class="pack-selected-items">
                <p class="empty-selection">Aucun élément sélectionné</p>
            </div>
            <div class="pack-total">
                <span>Total estimé:</span>
                <span class="pack-price">0 €</span>
            </div>
            <button class="pack-checkout-btn">Demander un devis</button>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Animation pour les éléments du pack
    const packItems = document.querySelectorAll('.pack-item');
    
    packItems.forEach(item => {
        // Animation d'entrée avec délai basé sur l'index
        const index = parseInt(item.dataset.index);
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add('fade-in');
        
        // Effet de flip au survol/clic
        item.addEventListener('click', function() {
            this.classList.toggle('flipped');
        });
        
        // Sélection d'un élément
        const selectBtn = item.querySelector('.pack-select-btn');
        if (selectBtn) {
            selectBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Empêcher la propagation au parent
                
                const itemTitle = item.querySelector('h3').textContent;
                const summaryContainer = document.querySelector('.pack-selected-items');
                const emptyMessage = summaryContainer.querySelector('.empty-selection');
                
                if (emptyMessage) {
                    emptyMessage.remove();
                }
                
                // Vérifier si l'élément est déjà sélectionné
                const existingItem = document.querySelector(`.selected-item[data-title="${itemTitle}"]`);
                
                if (!existingItem) {
                    // Ajouter l'élément au résumé
                    const selectedItem = document.createElement('div');
                    selectedItem.classList.add('selected-item');
                    selectedItem.setAttribute('data-title', itemTitle);
                    selectedItem.innerHTML = `
                        <span>${itemTitle}</span>
                        <span class="item-price">+ 299 €</span>
                        <button class="remove-item"><i class="fas fa-times"></i></button>
                    `;
                    summaryContainer.appendChild(selectedItem);
                    
                    // Mettre à jour le prix total
                    updateTotalPrice();
                    
                    // Ajouter l'événement pour supprimer l'élément
                    selectedItem.querySelector('.remove-item').addEventListener('click', function() {
                        selectedItem.remove();
                        updateTotalPrice();
                        
                        // Réafficher le message si aucun élément n'est sélectionné
                        if (summaryContainer.children.length === 0) {
                            const emptyMsg = document.createElement('p');
                            emptyMsg.classList.add('empty-selection');
                            emptyMsg.textContent = 'Aucun élément sélectionné';
                            summaryContainer.appendChild(emptyMsg);
                        }
                    });
                }
                
                // Fermer le flip
                setTimeout(() => {
                    item.classList.remove('flipped');
                }, 500);
            });
        }
    });
    
    // Fonction pour mettre à jour le prix total
    function updateTotalPrice() {
        const selectedItems = document.querySelectorAll('.selected-item');
        let total = 0;
        
        selectedItems.forEach(item => {
            const priceText = item.querySelector('.item-price').textContent;
            const price = parseInt(priceText.replace(/[^0-9]/g, ''));
            total += price;
        });
        
        document.querySelector('.pack-price').textContent = `${total} €`;
    }
    
    // Animation de l'image centrale
    const centerImage = document.querySelector('.pack-center-image img');
    if (centerImage) {
        centerImage.classList.add('floating-animation');
    }
    
    // Effet de connexion entre les éléments et l'image centrale
    const packItemsContainer = document.querySelector('.pack-items');
    if (packItemsContainer) {
        packItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                const centerGlow = document.querySelector('.pack-center-glow');
                centerGlow.style.opacity = '1';
                
                // Créer une ligne de connexion
                const connection = document.createElement('div');
                connection.classList.add('pack-connection-line');
                document.querySelector('.pack-selection-content').appendChild(connection);
                
                // Positionner la ligne
                const itemRect = item.getBoundingClientRect();
                const centerRect = document.querySelector('.pack-center').getBoundingClientRect();
                const contentRect = document.querySelector('.pack-selection-content').getBoundingClientRect();
                
                const startX = itemRect.left + itemRect.width/2 - contentRect.left;
                const startY = itemRect.top + itemRect.height/2 - contentRect.top;
                const endX = centerRect.left + centerRect.width/2 - contentRect.left;
                const endY = centerRect.top + centerRect.height/2 - contentRect.top;
                
                // Calculer l'angle et la longueur
                const angle = Math.atan2(endY - startY, endX - startX) * 180 / Math.PI;
                const length = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2));
                
                connection.style.width = `${length}px`;
                connection.style.left = `${startX}px`;
                connection.style.top = `${startY}px`;
                connection.style.transform = `rotate(${angle}deg)`;
                connection.style.transformOrigin = '0 0';
                
                // Animation d'apparition
                setTimeout(() => {
                    connection.style.opacity = '1';
                }, 10);
            });
            
            item.addEventListener('mouseleave', function() {
                const centerGlow = document.querySelector('.pack-center-glow');
                centerGlow.style.opacity = '0.5';
                
                // Supprimer les lignes de connexion
                const connections = document.querySelectorAll('.pack-connection-line');
                connections.forEach(conn => {
                    conn.style.opacity = '0';
                    setTimeout(() => {
                        conn.remove();
                    }, 300);
                });
            });
        });
    }
});
</script>
<script src="<?= BASE_URL ?>public/js/animations.js"></script>
<?php require_once 'app/views/containers/footer.php'; ?>