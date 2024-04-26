<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
*/

/* User Routes */
$routes->get('/', 'UserController::index');

/* Admin Routes */
$routes->post('admin/signup', 'AuthController::signup');
$routes->get('admin', 'AuthController::index');
$routes->get('admin/login', 'AuthController::index');
$routes->post('admin/login_user', 'AuthController::loginUser');
$routes->get('admin/dashboard', 'AdminController::index');

$routes->get('admin/logout', 'AuthController::logout');
$routes->get('admin/manage-products', 'AdminController::products');
$routes->get('admin/add-product', 'AdminController::addProduct');
$routes->post('admin/add_new_product', 'AdminController::saveProduct');
$routes->get('admin/edit-product/(:num)', 'AdminController::editProduct/$1');
$routes->post('admin/update_product', 'AdminController::saveProduct');
$routes->get('admin/delete-product/(:num)', 'AdminController::deleteProduct/$1');

$routes->get('products', 'UserController::products');
$routes->get('product/(:any)', 'UserController::productDetails/$1');
$routes->post('add_to_cart', 'UserController::addToCart');

$routes->get('cart', 'UserController::cart');
$routes->post('update_cart_qty', 'UserController::updateCartQty');
$routes->post('delete_cart', 'UserController::deleteCart');
$routes->get('checkout', 'UserController::checkout');
$routes->post('place_order', 'UserController::placeOrder');
