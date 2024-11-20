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





