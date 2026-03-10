<?php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $this->redirect('home/index');
            }
            else {
                $this->view('auth/login', [
                    'error' => 'Tài khoản hoặc mật khẩu không chính xác',
                    'title' => 'Đăng nhập - Đớ Store'
                ]);
            }
        }
        else {
            $this->view('auth/login', ['title' => 'Đăng nhập - Đớ Store']);
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');

            $data = [
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address'])
            ];

            // Basic Validation
            if (empty($data['username']) || empty($data['password']) || empty($data['full_name']) || empty($data['phone']) || empty($data['address'])) {
                $this->view('auth/register', ['error' => 'Vui lòng điền đủ tên đăng nhập, mật khẩu và họ tên.']);
                return;
            }

            if ($userModel->findByUsername($data['username'])) {
                $this->view('auth/register', ['error' => 'Tên đăng nhập đã tồn tại.']);
                return;
            }

            if ($userModel->create($data)) {
                // Auto-login after registration
                $user = $userModel->findByUsername($data['username']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $this->redirect('home/index');
            }
            else {
                $this->view('auth/register', ['error' => 'Có lỗi xảy ra, vui lòng thử lại.']);
            }
        }
        else {
            $this->view('auth/register', ['title' => 'Đăng ký - Đớ Store']);
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('home/index');
    }
}
