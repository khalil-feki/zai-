<?php
require_once 'app/models/Product.php';
require_once 'app/models/Category.php';

class HomeController {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    
    public function index() {
        // Get featured products (latest 8 products)
        $featuredProducts = $this->productModel->findAll(8, 0);
        
        // Get trending products
        $trendingProducts = $this->productModel->getTrendingProducts(4);
        
        // Get categories with products for display
        $dbCategories = $this->categoryModel->getCategoriesWithProducts();
        
        // Format categories for the view (map database fields to view fields)
        $categories = [];
        if (!empty($dbCategories)) {
            foreach ($dbCategories as $category) {
                $categories[] = [
                    'rowid' => $category['rowid'],
                    'name' => $category['label'], // Map 'label' to 'name'
                    'image' => !empty($category['image']) ? $category['image'] : 'public/images/category-default.jpg'
                ];
            }
        }
        
        // Make sure we have valid results before passing to the view
        if ($featuredProducts === false) {
            $featuredProducts = [];
        }
        
        // Load view
        require_once 'app/views/home/index.php';
    }
}
?>