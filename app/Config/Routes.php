<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


//for customer
$routes->get('/customer/register', 'CustomerController::register');
$routes->post('/customer/registerSubmit', 'CustomerController::registerSubmit');
$routes->get('/customer/login', 'CustomerController::login');
$routes->post('/customer/loginUser', 'CustomerController::loginUser');
$routes->get('/customer/logout', 'CustomerController::logout');
$routes->get('/customer/dashboard', 'CustomerController::dashboard');

$routes->get('/customer/menu/(:segment)', 'CustomerController::menu/$1');
$routes->post('customer/store-location', 'CustomerController::storeLocation');





//from restaurant
$routes->get('/restaurant/login', 'RestaurantController::login');
$routes->get('/restaurant/logout', 'RestaurantController::logout');
$routes->post('/restaurant/loginSubmit', 'RestaurantController::loginSubmit');
$routes->get('/restaurant/register', 'RestaurantController::register');
$routes->post('/restaurant/registerSubmit', 'RestaurantController::registerSubmit');
$routes->get('/restaurant/dashboard', 'RestaurantDashboard::index');
$routes->post('restaurant/addMenuItem', 'RestaurantDashboard::addMenuItem');
$routes->post('/restaurant/updateQuantity/(:num)', 'RestaurantDashboard::updateQuantity/$1');
$routes->post('restaurant/deleteMenuItem/(:num)', 'RestaurantDashboard::deleteMenuItem/$1');
$routes->post('/restaurant/toggleStatus/(:num)', 'RestaurantDashboard::toggleStatus/$1');
//closed or open
$routes->post('/restaurant/updateStatus', 'RestaurantController::updateStatus');
$routes->get('/restaurant/mainmenu', 'RestaurantDashboard::mainmenu');





$routes->post('customer/toggleFavorite', 'CustomerController::toggleFavorite');

//for cart 
$routes->get('customer/checkout', 'CheckoutController::index');
$routes->post('customer/checkout', 'CheckoutController::checkout');
$routes->post('/apply-coupon', 'CheckoutController::applyCoupon');
$routes->get('/reset-discount', 'CheckoutController::resetDiscount');


$routes->get('/customer/editprofile', 'CustomerController::editProfile'); 
$routes->post('/customer/updateprofile', 'CustomerController::updateProfile');





//for payment

$routes->post('initiate-payment', 'CheckoutController::initiatePayment');


//for admin 

$routes->get('/admin/dashboard', 'AdminController::dashboard');
$routes->get('/admin/approve/(:num)', 'AdminController::approve/$1');
$routes->get('/admin/disapprove/(:num)', 'AdminController::disapprove/$1');
$routes->get('/admin/view/(:num)', 'AdminController::view/$1');

