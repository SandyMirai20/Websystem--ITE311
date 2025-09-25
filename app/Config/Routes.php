<?php

use CodeIgniter\Router\RouteCollection;
use App\Filters\RoleFilter;

/**
 * @var RouteCollection $routes
 */

// Home routes
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('contact', 'Home::contact');

// Authentication routes
$routes->group('', ['namespace' => 'App\Controllers'], function($routes) {
    // Public routes
    $routes->get('/register', 'Auth::register');
    $routes->post('/register', 'Auth::register');
    $routes->get('/login', 'Auth::login');
    $routes->post('/login', 'Auth::login');
    
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->get('/logout', 'Auth::logout');
        $routes->get('/dashboard', 'Auth::dashboard', ['as' => 'dashboard']);
        
        // Admin routes
        $routes->group('admin', ['filter' => 'role:admin'], function($routes) {
            
        });
        
        // Teacher routes
        $routes->group('teacher', ['filter' => 'role:teacher'], function($routes) {
            
        });
        
        // Student routes
        $routes->group('student', ['filter' => 'role:student'], function($routes) {
            
        });
    });
});
