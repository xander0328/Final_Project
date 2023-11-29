<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/getClerkTask', 'MainController::getClerkTask');
$routes->post('/getClientData', 'MainController::getClientData');
$routes->post('/approveClient', 'MainController::approveClient');
