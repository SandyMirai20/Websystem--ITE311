<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EnrollmentModel;

class Student extends BaseController
{
    protected $enrollmentModel;
    
    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
        helper(['form', 'url']);
    }

    public function enrolledCourses()
    {
        // Check if user is logged in and is a student
        if (!session()->has('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/login')->with('error', 'Please login as a student to view this page.');
        }

        $userId = session()->get('userID');
        
        // Get enrolled courses with course details
        $enrollments = $this->enrollmentModel->getUserEnrollments($userId);
        
        $data = [
            'title' => 'My Enrolled Courses',
            'enrollments' => $enrollments,
            'user' => [
                'id' => $userId,
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];
        
        return view('student/enrolled_courses', $data);
    }
}
