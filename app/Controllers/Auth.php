<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to(session()->get('role') === 'admin' ? 'admin/dashboard' : 'dashboard');
        }

        $data = [
            'title' => 'Login',
        ];

        return view('auth/login', $data);
    }

    public function attempt()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
        }

        session()->set([
            'user_id' => $user['id'],
            'name'    => $user['name'],
            'role'    => $user['role'],
        ]);

        return redirect()->to($user['role'] === 'admin' ? 'admin/dashboard' : 'dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
