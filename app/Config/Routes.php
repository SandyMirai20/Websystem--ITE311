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
        // Enrollment action (AJAX)
        $routes->post('/course/enroll', 'Course::enroll', ['filter' => 'csrf']);
        // Front-controller alias when index.php is present in path
        $routes->post('index.php/course/enroll', 'Course::enroll', ['filter' => 'csrf']);
        
      
        // Admin routes
        $routes->group('admin', ['filter' => 'role:admin'], function($routes) {
            // Courses management
            $routes->get('courses', 'Admin\Courses::index');
            $routes->get('courses/create', 'Admin\Courses::create');
            $routes->post('courses', 'Admin\Courses::store', ['filter' => 'csrf']);
        });
        
        // Student routes
        $routes->group('student', ['filter' => 'role:student'], function($routes) {
            $routes->get('courses', 'Student\Enroll::index', ['as' => 'student.courses']);
            $routes->get('enrollcourses', 'Student\Enroll::index', ['as' => 'student.enrollcourses']);
            $routes->get('courses/list', 'Student\Enroll::courses', ['as' => 'student.courses.list']);
            $routes->get('courses/(:num)', 'Student\Enroll::view/$1', ['as' => 'student.course.view']);
            
            // Enrollment route - map to unified Course::enroll for compatibility
            $routes->post('enroll', 'Course::enroll', ['as' => 'student.enroll', 'filter' => 'csrf']);
            // Backward-compat endpoint sometimes used in view scripts
            $routes->post('enrollcourse', 'Course::enroll', ['as' => 'student.enrollcourse', 'filter' => 'csrf']);
        });
    });
});
