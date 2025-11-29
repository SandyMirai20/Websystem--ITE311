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

        // Notification routes
        $routes->get('/notifications', 'Notifications::get');
        $routes->post('/notifications/mark_read/(:num)', 'Notifications::mark_as_read/$1');
        
      
        // Admin routes
        $routes->group('admin', ['filter' => 'role:admin'], function($routes) {
            // Courses management
            $routes->get('courses', 'Admin\Courses::index');
            $routes->get('courses/create', 'Admin\Courses::create');
            $routes->post('courses', 'Admin\Courses::store', ['filter' => 'csrf']);
            $routes->get('courses/show/(:num)', 'Admin\Courses::show/$1', ['as' => 'admin.course.show']);
        });

        // Materials routes
        $routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
        $routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
        $routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
        $routes->get('/materials/download/(:num)', 'Materials::download/$1');

        // Teacher routes
        $routes->group('teacher', ['filter' => 'role:teacher'], function($routes) {
            $routes->get('courses', 'Teacher\Courses::index', ['as' => 'teacher.courses']);
            $routes->get('courses/(:num)', 'Teacher\Courses::show/$1', ['as' => 'teacher.course.show']);
            $routes->get('course/(:num)/upload', 'Materials::upload/$1');
            $routes->post('course/(:num)/upload', 'Materials::upload/$1');
        });
        $routes->group('student', ['filter' => 'role:student'], function($routes) {
            $routes->get('courses', 'Student\Enroll::index', ['as' => 'student.courses']);
            $routes->get('enrollcourses', 'Student\Enroll::index', ['as' => 'student.enrollcourses']);
            $routes->get('courses/list', 'Student\Enroll::courses', ['as' => 'student.courses.list']);
            $routes->get('courses/(:num)', 'Student\Enroll::view/$1', ['as' => 'student.course.view']);
            $routes->get('enrolled-courses', 'Student\Enroll::enrolledCourses', ['as' => 'student.enrolled.courses']);
            
            // Course search routes
            $routes->get('courses/search', 'Course::search');
            $routes->post('courses/search', 'Course::search');

            // Enrollment route - map to unified Course::enroll for compatibility
            $routes->post('enroll', 'Course::enroll', ['as' => 'student.enroll', 'filter' => 'csrf']);
            // Backward-compat endpoint sometimes used in view scripts
            $routes->post('enrollcourse', 'Course::enroll', ['as' => 'student.enrollcourse', 'filter' => 'csrf']);
        });
    });
});
