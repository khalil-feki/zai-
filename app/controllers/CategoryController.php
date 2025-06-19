<?php
require_once 'app/models/Category.php';
require_once 'app/models/Product.php';

class CategoryController {
    private $categoryModel;
    private $productModel;
    
    public function __construct() {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
    }
    
    /**
     * Display all categories
     */
    public function index() {
        $categories = $this->categoryModel->getCategoriesWithProducts();
        
        // Get featured products for the homepage
        $featuredProducts = $this->productModel->getFeaturedProducts(8);
        
        // Get trending products (could be based on sales or views)
        $trendingProducts = $this->productModel->getTrendingProducts(4);
        
        // Load view
        require_once 'app/views/categories/index.php';
    }
    
    /**
     * Display products in a category
     * @param int $id Category ID
     */
    public function view($id) {
        // Get all categories for the sidebar (only those with products)
        $categories = $this->categoryModel->getCategoriesWithProducts();
        
        // Get the current category
        $currentCategory = $this->categoryModel->getById($id);
        
        if (!$currentCategory) {
            $_SESSION['error'] = 'Category not found';
            redirect('category');
            return;
        }
        
        // Get sorting parameters
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
        $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : null;
        $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Get products in this category with filters
        $products = $this->productModel->findByCategory($id);
        
        // Apply additional filtering
        if (!empty($search) || $minPrice !== null || $maxPrice !== null) {
            $filteredProducts = [];
            
            foreach ($products as $product) {
                // Apply search filter
                if (!empty($search) && 
                    stripos($product['label'], $search) === false && 
                    stripos($product['description'] ?? '', $search) === false) {
                    continue;
                }
                
                // Apply price filters
                if ($minPrice !== null && $product['price'] < $minPrice) {
                    continue;
                }
                
                if ($maxPrice !== null && $product['price'] > $maxPrice) {
                    continue;
                }
                
                $filteredProducts[] = $product;
            }
            
            $products = $filteredProducts;
        }
        
        // Apply sorting
        if ($sort === 'price_asc') {
            usort($products, function($a, $b) {
                return $a['price'] <=> $b['price'];
            });
        } elseif ($sort === 'price_desc') {
            usort($products, function($a, $b) {
                return $b['price'] <=> $a['price'];
            });
        } elseif ($sort === 'name_asc') {
            usort($products, function($a, $b) {
                return strcasecmp($a['label'], $b['label']);
            });
        } elseif ($sort === 'name_desc') {
            usort($products, function($a, $b) {
                return strcasecmp($b['label'], $a['label']);
            });
        }
        
        // Load view
        require_once 'app/views/categories/view.php';
    }
}
?>