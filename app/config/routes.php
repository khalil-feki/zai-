<?php
// Define routes

$router = new Router();

// Home route
$router->addRoute('', 'HomeController', 'index');
$router->addRoute('home', 'HomeController', 'index');

// Auth routes
$router->addRoute('auth/login', 'AuthController', 'login');
$router->addRoute('auth/register', 'AuthController', 'register');
$router->addRoute('auth/logout', 'AuthController', 'logout');

// Product routes
$router->addRoute('products', 'ProductController', 'index');
$router->addRoute('product/view/{id}', 'ProductController', 'view');
$router->addRoute('product/search', 'ProductController', 'search');

// User routes
$router->addRoute('user/profile', 'UserController', 'profile');
$router->addRoute('user/update', 'UserController', 'update');
$router->addRoute('user/orders', 'UserController', 'orders');
$router->addRoute('user/addresses', 'UserController', 'addresses');
$router->addRoute('user/saveAddress', 'UserController', 'saveAddress');

// Cart routes
$router->addRoute('cart', 'CartController', 'index');
$router->addRoute('cart/add', 'CartController', 'add');
$router->addRoute('cart/update', 'CartController', 'update');
$router->addRoute('cart/remove', 'CartController', 'remove');

// Checkout routes (fix the routing)
$router->addRoute('checkout', 'CheckoutController', 'index');
$router->addRoute('checkout/process', 'CheckoutController', 'process');
$router->addRoute('checkout/success/{id}', 'CheckoutController', 'success');

// Category routes
$router->addRoute('category', 'CategoryController', 'index');
$router->addRoute('category/view/{id}', 'CategoryController', 'view');

// Order routes
$router->addRoute('orders', 'OrdersController', 'index');
$router->addRoute('orders/view/{id}', 'OrdersController', 'view');
$router->addRoute('orders/searchByEmail', 'OrdersController', 'searchByEmail');

// Ticket routes
$router->addRoute('tickets', 'TicketController', 'index');
$router->addRoute('ticket/create', 'TicketController', 'create');
$router->addRoute('ticket/submit', 'TicketController', 'submit');
$router->addRoute('ticket/view/{id}', 'TicketController', 'view');
$router->addRoute('ticket/list', 'TicketController', 'list');

// Process the request
$router->dispatch();
?>