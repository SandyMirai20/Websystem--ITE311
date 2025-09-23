<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $validation;
    
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    
    public function register()
    {
        $db = \Config\Database::connect();
        
        if ($this->request->getMethod() === 'POST') {
            // Get raw input for validation
            $input = $this->request->getPost();
            
            // Set validation rules with stricter patterns
            $validationRules = [
                'name' => [
                    'label' => 'Full Name',
                    'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[\p{L}\s\'\-\.]+$/u]',
                    'errors' => [
                        'required' => 'Name is required.',
                        'min_length' => 'Name must be at least 3 characters long.',
                        'max_length' => 'Name cannot exceed 50 characters.',
                        'regex_match' => 'Name can only contain letters, spaces, hyphens, apostrophes, and dots.'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|max_length[100]|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.',
                        'max_length' => 'Email cannot exceed 100 characters.',
                        'is_unique' => 'This email is already registered.'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[8]|max_length[255]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'max_length' => 'Password cannot exceed 255 characters.',
                        'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
                    ]
                ],
                'password_confirm' => [
                    'label' => 'Password Confirmation',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Password confirmation is required.',
                        'matches' => 'Password confirmation does not match.'
                    ]
                ]
            ];

            // Set data for validation
            $this->validation->setRules($validationRules);

            if ($this->validation->run($input)) {
                // Generate secure password hash
                $hashedPassword = password_hash($input['password'], PASSWORD_BCRYPT);

                // Prepare user data with escaped values
                $userData = [
                    'name' => esc($input['name']),
                    'email' => filter_var($input['email'], FILTER_SANITIZE_EMAIL),
                    'password' => $hashedPassword,
                    'role' => 'student',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Use Query Builder with parameter binding to prevent SQL injection
                $builder = $db->table('users');
                
                try {
                    if ($builder->insert($userData)) {
                        $userId = $db->insertID();
                        
                        // Clear sensitive data
                        unset($userData['password']);
                        
                        // Set success message with escaped output
                        session()->setFlashdata('success', 'Registration successful! Please log in.');
                        return redirect()->to('/login');
                    }
                } catch (\Exception $e) {
                    // Log the error but don't expose details to the user
                    log_message('error', 'Registration error: ' . $e->getMessage());
                    session()->setFlashdata('error', 'An error occurred during registration. Please try again.');
                }
            } else {
                // Get validation errors
                $errors = $this->validation->getErrors();
                
                // Sanitize error messages before displaying
                array_walk($errors, function(&$value, $key) {
                    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                });
                
                session()->setFlashdata('errors', $errors);
                
                // Repopulate form with sanitized input
                session()->setFlashdata('form_data', [
                    'name' => esc($input['name'] ?? ''),
                    'email' => filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL)
                ]);
            }
        }

        return view('auth/register');
    }

    public function login()
    {
        $db = \Config\Database::connect();
        
        if ($this->request->getMethod() === 'POST') {
            
            $validationRules = [
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password is required.'
                    ]
                ]
            ];

            if ($this->validate($validationRules)) {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Check if user exists
                $builder = $db->table('users');
                $user = $builder->where('email', $email)->get()->getRowArray();

                if ($user && password_verify($password, $user['password'])) {
                    // Create user session
                    $sessionData = [
                        'userID' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'isLoggedIn' => true
                    ];
                    
                    session()->set($sessionData);
                    session()->setFlashdata('success', 'Welcome, ' . $user['name'] . '!');
                    return redirect()->to('/dashboard');
                } else {
                    session()->setFlashdata('error', 'Invalid email or password.');
                }
            } else {
                session()->setFlashdata('errors', $this->validator->getErrors());
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userData = [
            'user' => [
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];

        $role = strtolower(session()->get('role') ?? 'student');
        
        switch ($role) {
            case 'admin':
                return view('dashboard/admindashboard', $userData);
            case 'instructor':
                return view('dashboard/instructordashboard', $userData);
            case 'student':
            default:
                return view('dashboard/studentdashboard', $userData);
        }
    }
}
