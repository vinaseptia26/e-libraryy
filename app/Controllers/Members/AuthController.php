<?php

namespace App\Controllers\Members;

use App\Controllers\BaseController;
use App\Models\MemberModel;

class AuthController extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $model = new MemberModel();
            $member = $model->where('email', $email)->first();

            if ($member && password_verify($password, $member['password'])) {
                session()->set([
                    'member_id' => $member['id'],
                    'member_name' => $member['first_name'],
                    'is_logged_in' => true
                ]);
                return redirect()->to('/members/dashboard');
            }

            return redirect()->back()->with('error', 'Email atau password salah.');
        }

        return view('auth/login_members');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name'        => 'required',
                'email'             => 'required|valid_email|is_unique[members.email]',
                'password'          => 'required|min_length[6]',
                'password_confirm'  => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('error', $this->validator->getErrors())->withInput();
            }

            $model = new MemberModel();

            $model->save([
                'uid'           => uniqid('MBR-'),
                'first_name'    => $this->request->getPost('first_name'),
                'last_name'     => $this->request->getPost('last_name'),
                'email'         => $this->request->getPost('email'),
                'phone'         => $this->request->getPost('phone'),
                'address'       => $this->request->getPost('address'),
                'date_of_birth' => $this->request->getPost('date_of_birth'),
                'gender'        => $this->request->getPost('gender'),
                'qr_code'       => strtoupper(bin2hex(random_bytes(4))),
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ]);

            return redirect()->to('/members/login')->with('success', 'Registrasi berhasil. Silakan login.');
        }

        return view('auth/register_members');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/members/login');
    }
}
