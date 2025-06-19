<?php
require_once 'app/models/Product.php';
require_once 'app/models/Cart.php';

class ProductController {
    private $productModel;
    private $cartModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->cartModel = new Cart();
    }
    
    /**
     * Display product details with cart information
     * @param int $id Product ID
     */
    public function view($id) {
        // Get product details
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found';
            redirect('');
            return;
        }
        
        // Get cart information for this product (if user is logged in)
        $cartItem = null;
        if (isset($_SESSION['user_id'])) {
            $cartItem = $this->cartModel->getCartItem($_SESSION['user_id'], $id);
        }
        
        // Get related products from the same category
        $categoryId = $product['fk_categorie'] ?? null;
        if ($categoryId) {
            $relatedProducts = $this->productModel->findByCategory($categoryId, 4);
            
            // Remove current product from related products
            $relatedProducts = array_filter($relatedProducts, function($p) use ($id) {
                return $p['rowid'] != $id;
            });
        } else {
            $relatedProducts = [];
        }
        
        // Load view
        require_once 'app/views/products/detail.php';
    }
}
?>