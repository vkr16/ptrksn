<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $session;
    protected $userModel;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = model('UserModel', true, $db);
    }

    public function index()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(HOST_URL . '/admin');
            } else {
                return redirect()->to(HOST_URL . '/user');
            }
        }
        // Session Check End


        return view('auth/login');
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($userData = $this->userModel->find($email)) {
            if ($userData['status'] == 'Active') {
                if (password_verify($password, $userData['password'])) {
                    $sessionData = [
                        'fw2_webclient_session' => $email,
                        'fw2_webclient_role' => $userData['role']
                    ];
                    $this->session->set($sessionData);
                    if ($userData['role'] == 'Admin') {
                        return redirect()->to(HOST_URL . '/admin');
                    } else {
                        return redirect()->to(HOST_URL . '/user');
                    }
                } else {
                    setcookie("login", 'incorrect', time() + 10);
                    return redirect()->to(HOST_URL . '/login');
                }
            } else if ($userData['status'] == 'Deleted') {
                setcookie("login", 'notexist', time() + 10);
                return redirect()->to(HOST_URL . '/login');
            } else {
                setcookie("login", 'suspended', time() + 10);
                return redirect()->to(HOST_URL . '/login');
            }
        } else {
            setcookie("login", 'notexist', time() + 10);
            return redirect()->to(HOST_URL . '/login');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(HOST_URL . '/login');
    }
}
