<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\EnrollmentModel;

class Materials extends BaseController
{
    protected $materialModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    public function upload($course_id = null)
    {
        // Admin or Teacher only
        $this->requireRole(['admin', 'teacher']);

        if (!$course_id) {
            if ($this->hasRole('admin')) {
                return redirect()->to('/admin/courses')->with('error', 'Course ID is required.');
            } else {
                return redirect()->to('/teacher/courses')->with('error', 'Course ID is required.');
            }
        }

        // Check if course exists
        $db = \Config\Database::connect();
        $course = $db->table('courses')->where('id', $course_id)->get()->getRowArray();

        if (!$course) {
            if ($this->hasRole('admin')) {
                return redirect()->to('/admin/courses')->with('error', 'Course not found.');
            } else {
                return redirect()->to('/teacher/courses')->with('error', 'Course not found.');
            }
        }

        // If teacher, verify they own this course
        if ($this->hasRole('teacher') && !$this->hasRole('admin')) {
            if ($course['teacher_id'] != $this->userData['id']) {
                return redirect()->to('/teacher/courses')->with('error', 'You do not have permission to upload materials to this course.');
            }
        }

        // Handle POST request (file upload)
        if ($this->request->is('post')) {
            return $this->handleUpload($course_id);
        }

        // Display upload form (GET request)
        $viewPath = $this->hasRole('admin') ? 'admin/materials/upload' : 'teacher/materials/upload';
        return $this->render($viewPath, [
            'title' => 'Upload Course Material',
            'course' => $course,
            'validation' => \Config\Services::validation(),
        ]);
    }

    private function handleUpload($course_id)
    {
        $validation = \Config\Services::validation();

        // Set validation rules for file upload
        $validation->setRules([
            'material_file' => [
                'label' => 'Material File',
                'rules' => 'uploaded[material_file]|max_size[material_file,10240]|ext_in[material_file,pdf,doc,docx,ppt,pptx,xls,xlsx,zip]',
                'errors' => [
                    'uploaded' => 'Please select a file to upload.',
                    'max_size' => 'File size must not exceed 10MB.',
                    'ext_in' => 'Only PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, and ZIP files are allowed.',
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('errors', $validation->getErrors())
                ->withInput();
        }

        $file = $this->request->getFile('material_file');

        if (!$file->isValid()) {
            return redirect()->back()
                ->with('error', 'File upload failed: ' . $file->getErrorString())
                ->withInput();
        }

        // Generate unique filename to prevent conflicts
        $originalName = $file->getName();
        $extension = $file->getExtension();
        $newName = uniqid() . '_' . time() . '.' . $extension;

        // Create course-specific directory
        $uploadPath = WRITEPATH . 'uploads/course_materials/' . $course_id;
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0755, true)) {
                return redirect()->back()
                    ->with('error', 'Failed to create upload directory. Please check permissions.')
                    ->withInput();
            }
        }

        // Move file to upload directory
        if (!$file->move($uploadPath, $newName)) {
            return redirect()->back()
                ->with('error', 'Failed to move uploaded file.')
                ->withInput();
        }

        // Debug logging
        log_message('debug', 'Upload attempt - Course ID: ' . $course_id);
        log_message('debug', 'Upload attempt - User ID: ' . $this->userData['id']);
        log_message('debug', 'Upload attempt - User Role: ' . $this->userData['role']);

        // Verify course exists before proceeding
        $db = \Config\Database::connect();
        $courseExists = $db->table('courses')->where('id', $course_id)->countAllResults();

        log_message('debug', 'Course exists check: ' . $courseExists);

        if ($courseExists === 0) {
            log_message('error', 'Course ID ' . $course_id . ' does not exist in database');
            return redirect()->back()
                ->with('error', 'Invalid course selected. Please select a valid course.')
                ->withInput();
        }

        // Save to database
        $data = [
            'course_id' => $course_id,
            'file_name' => $originalName,
            'file_path' => 'course_materials/' . $course_id . '/' . $newName,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->materialModel->insertMaterial($data);

            if ($this->hasRole('admin')) {
                return redirect()->to('/admin/courses/show/' . $course_id)
                    ->with('success', 'Material uploaded successfully!');
            } else {
                return redirect()->to('/teacher/courses/' . $course_id)
                    ->with('success', 'Material uploaded successfully!');
            }
        } catch (\Exception $e) {
            // Clean up uploaded file if database insert fails
            if (file_exists($uploadPath . '/' . $newName)) {
                unlink($uploadPath . '/' . $newName);
            }

            log_message('error', 'Error uploading material: ' . $e->getMessage());
            log_message('error', 'Upload data: ' . print_r($data, true));

            // Provide more specific error message based on the exception
            $errorMessage = 'Failed to save material to database. Please try again.';
            if (strpos($e->getMessage(), 'foreign key') !== false) {
                $errorMessage = 'Invalid course selected. Please select a valid course.';
            } elseif (strpos($e->getMessage(), 'duplicate') !== false) {
                $errorMessage = 'A material with this name already exists for this course.';
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    public function delete($material_id = null)
    {
        // Admin or Teacher only
        $this->requireRole(['admin', 'teacher']);

        if (!$material_id) {
            if ($this->hasRole('admin')) {
                return redirect()->to('/admin/courses')->with('error', 'Material ID is required.');
            } else {
                return redirect()->to('/teacher/courses')->with('error', 'Material ID is required.');
            }
        }

        // Get material details
        $material = $this->materialModel->find($material_id);

        if (!$material) {
            if ($this->hasRole('admin')) {
                return redirect()->to('/admin/courses')->with('error', 'Material not found.');
            } else {
                return redirect()->to('/teacher/courses')->with('error', 'Material not found.');
            }
        }

        // If teacher, verify they own this course
        if ($this->hasRole('teacher') && !$this->hasRole('admin')) {
            $db = \Config\Database::connect();
            $course = $db->table('courses')->where('id', $material['course_id'])->get()->getRowArray();

            if (!$course || $course['teacher_id'] != $this->userData['id']) {
                return redirect()->to('/teacher/courses')->with('error', 'You do not have permission to delete this material.');
            }
        }

        try {
            // Delete physical file
            $filePath = WRITEPATH . 'uploads/' . $material['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete database record
            $this->materialModel->delete($material_id);

            if ($this->hasRole('admin')) {
                return redirect()->to('/admin/courses/show/' . $material['course_id'])
                    ->with('success', 'Material deleted successfully!');
            } else {
                return redirect()->to('/teacher/courses/' . $material['course_id'])
                    ->with('success', 'Material deleted successfully!');
            }

        } catch (\Exception $e) {
            log_message('error', 'Error deleting material: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete material. Please try again.');
        }
    }

    public function download($material_id = null)
    {
        // Require login
        $this->requireLogin();

        if (!$material_id) {
            return redirect()->back()->with('error', 'Material ID is required.');
        }

        // Get material details
        $material = $this->materialModel->find($material_id);

        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Check if user is enrolled in the course (students) or is admin/teacher
        $canDownload = false;
        $userId = $this->userData['id'];

        // Admin can download any material
        if ($this->hasRole('admin')) {
            $canDownload = true;
        } else {
            // Check if user is the teacher of the course
            $db = \Config\Database::connect();
            $course = $db->table('courses')->where('id', $material['course_id'])->get()->getRowArray();

            if ($course && $course['teacher_id'] == $userId) {
                $canDownload = true;
            } else {
                // Check if student is enrolled in the course
                $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $material['course_id']);
                if ($isEnrolled) {
                    $canDownload = true;
                }
            }
        }

        if (!$canDownload) {
            return redirect()->back()->with('error', 'You do not have permission to download this material.');
        }

        // Check if file exists
        $filePath = WRITEPATH . 'uploads/' . $material['file_path'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        // Force download
        return $this->response->download($filePath, null)->setFileName($material['file_name']);
    }
}
