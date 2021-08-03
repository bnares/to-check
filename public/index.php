<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Composer
 */
require '../vendor/autoload.php';
use \App\Controllers\test;

/**
 * Twig
 */
Twig_Autoloader::register();


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('login', ['controller'=>'Login', 'action'=>'new']);
$router->add('logout', ['controller'=>'Login', 'action'=>'destroy']);
    
$router->dispatch($_SERVER['QUERY_STRING']);

//var_dump('front controller: '.test::getAllAsignedIncomes(15));

