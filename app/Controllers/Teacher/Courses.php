<?php

namespace App\Controllers\Teacher;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\MaterialModel;

class Courses extends BaseController
{
    protected $courseModel;
    protected $materialModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->materialModel = new MaterialModel();
    }

    public function index()
    {
        // Teacher only
        $this->requireRole('teacher');

        $teacherId = $this->userData['id'];

        // Get courses where this teacher is assigned
        $courses = $this->courseModel->where('teacher_id', $teacherId)->findAll();

        // Add materials count for each course
        foreach ($courses as &$course) {
            $course['materials_count'] = $this->materialModel->where('course_id', $course['id'])->countAllResults();
        }

        return $this->render('teacher/courses/index', [
            'title' => 'My Courses',
            'courses' => $courses,
        ]);
    }

    public function show($courseId = null)
    {
        // Teacher only
        $this->requireRole('teacher');

        $teacherId = $this->userData['id'];

        // Get course and verify teacher owns it
        $course = $this->courseModel->where('id', $courseId)
                                  ->where('teacher_id', $teacherId)
                                  ->first();

        if (!$course) {
            return redirect()->to('/teacher/courses')->with('error', 'Course not found or you do not have permission to access it.');
        }

        // Get materials for this course
        $materials = $this->materialModel->getMaterialsByCourse($courseId);

        return $this->render('teacher/courses/show', [
            'title' => 'Course: ' . $course['course'],
            'course' => $course,
            'materials' => $materials,
        ]);
    }
}
