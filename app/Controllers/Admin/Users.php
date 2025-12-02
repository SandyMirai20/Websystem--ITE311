<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('id', 'DESC')->findAll();
        return $this->render('admin/users/index', [
            'title' => 'Manage Users',
            'users' => $users,
        ]);
    }

    public function create()
    {
        return $this->render('admin/users/create', [
            'title' => 'Add User',
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'role' => 'required|in_list[admin,teacher,student]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
            'is_active' => 1,
        ];

        $this->userModel->insert($data);
        return redirect()->to('/admin/users')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return $this->render('admin/users/edit', [
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $emailRule = ($user['email'] === $this->request->getPost('email'))
            ? 'required|valid_email'
            : 'required|valid_email|is_unique[users.email]';

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => $emailRule,
            'role' => 'required|in_list[admin,teacher,student]',
            'password' => 'permit_empty|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to('/admin/users')->with('success', 'User updated successfully.');
    }

    public function changeRole($id)
    {
        $role = $this->request->getPost('role');
        if (!in_array($role, ['admin', 'teacher', 'student'], true)) {
            return redirect()->back()->with('error', 'Invalid role.');
        }
        $this->userModel->update($id, ['role' => $role]);
        return redirect()->to('/admin/users')->with('success', 'Role updated.');
    }

    public function deactivate($id)
    {
        $this->userModel->update($id, ['is_active' => 0]);
        return redirect()->to('/admin/users')->with('success', 'User deactivated.');
    }

    public function activate($id)
    {
        $this->userModel->update($id, ['is_active' => 1]);
        return redirect()->to('/admin/users')->with('success', 'User activated.');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User deleted.');
    }

    public function resetPassword($id)
    {
        $rules = [
            'password' => 'required|min_length[8]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $password = $this->request->getPost('password');
        $this->userModel->update($id, ['password' => password_hash($password, PASSWORD_BCRYPT)]);
        return redirect()->to('/admin/users')->with('success', 'Password reset successfully.');
    }
}
