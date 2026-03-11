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

                // Lưu customer_id vào session nếu có
                $customerModel = $this->model('Customer');
                if ($customerModel) {
                    // Tìm customer theo user_id trước
                    $customer = $customerModel->findByUserId($user['id']);
                    
                    if (!$customer) {
                        // Nếu không tìm thấy theo user_id, tìm theo username
                        $customer = $customerModel->findByUsername($user['username']);
                    }
                    
                    if ($customer) {
                        $_SESSION['customer_id'] = $customer['id'];
                        
                        // Cập nhật user_id nếu chưa có
                        if (empty($customer['user_id'])) {
                            $customerModel->update($customer['id'], ['user_id' => $user['id']]);
                        }
                    }
                    else {
                        // Tạo customer mới nếu chưa có
                        $customerData = [
                            'username' => $user['username'],
                            'full_name' => $user['full_name'],
                            'email' => $user['email'],
                            'phone' => $user['phone'],
                            'address' => $user['address'] ?? '',
                            'password' => $user['password'], // Đã hash sẵn
                            'user_id' => $user['id']
                        ];
                        $customerId = $customerModel->create($customerData);
                        if ($customerId) {
                            $_SESSION['customer_id'] = $customerId;
                        }
                    }
                }

                // Redirect to intended page or home
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirectUrl = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    if (strpos($redirectUrl, '/shop_giay/') === 0) {
                        header('Location: ' . $redirectUrl);
                        exit();
                    }
                    $this->redirect($redirectUrl);
                }
                else {
                    $this->redirect('home/index');
                }
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
            $customerModel = $this->model('Customer');

            $data = [
                'username' => trim($_POST['username']),
                'password' => $_POST['password'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address'])
            ];

            // Basic Validation
            $errors = [];
            if (empty($data['username'])) {
                $errors[] = 'Vui lòng nhập tên đăng nhập.';
            }
            if (empty($data['password'])) {
                $errors[] = 'Vui lòng nhập mật khẩu.';
            }
            elseif (strlen($data['password']) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            }
            if (empty($data['full_name'])) {
                $errors[] = 'Vui lòng nhập họ tên.';
            }
            if (empty($data['phone'])) {
                $errors[] = 'Vui lòng nhập số điện thoại.';
            }
            if (empty($data['address'])) {
                $errors[] = 'Vui lòng nhập địa chỉ.';
            }

            if (!empty($errors)) {
                $this->view('auth/register', ['error' => implode('<br>', $errors)]);
                return;
            }

            // Kiểm tra username trong bảng users
            if ($userModel->findByUsername($data['username'])) {
                $this->view('auth/register', ['error' => 'Tên đăng nhập đã tồn tại.']);
                return;
            }

            // Kiểm tra username trong bảng customers
            if ($customerModel->findByUsername($data['username'])) {
                $this->view('auth/register', ['error' => 'Tên đăng nhập đã tồn tại trong hệ thống khách hàng.']);
                return;
            }

            // Kiểm tra email nếu có
            if (!empty($data['email'])) {
                $existingCustomer = $customerModel->findByEmail($data['email']);
                if ($existingCustomer) {
                    $this->view('auth/register', ['error' => 'Email đã được sử dụng.']);
                    return;
                }
            }

            // Kiểm tra phone nếu có
            if (!empty($data['phone'])) {
                $existingPhone = $customerModel->findByPhone($data['phone']);
                if ($existingPhone) {
                    $this->view('auth/register', ['error' => 'Số điện thoại đã được sử dụng.']);
                    return;
                }
            }

            // Mã hóa mật khẩu
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;

            try {
                // KHÔNG DÙNG TRANSACTION - VÌ MyISAM không hỗ trợ
                // Tạo user trước
                $userId = $userModel->create($data);

                if (!$userId) {
                    throw new Exception("Không thể tạo tài khoản người dùng.");
                }
                usleep(100000);
                $checkUser = $userModel->findById($userId);
                error_log("AuthController::register - checkUser: " . ($checkUser ? 'FOUND' : 'NOT FOUND'));
                if (!$checkUser) {
    // Thử tìm bằng username
                $checkUser = $userModel->findByUsername($data['username']);
                error_log("AuthController::register - findByUsername: " . ($checkUser ? 'FOUND' : 'NOT FOUND'));
                
                if ($checkUser) {
                    $userId = $checkUser['id'];
                    error_log("AuthController::register - using userId from username: " . $userId);
                } else {
                    throw new Exception("User vừa tạo không tồn tại.");
                }
            }
                            // Tạo customer với cùng username và thông tin, kèm user_id
                $customerData = [
                    'username' => $data['username'],
                    'password' => $hashedPassword,
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'user_id' => $userId // Gán user_id để phân biệt
                ];

                $customerId = $customerModel->create($customerData);

                if (!$customerId) {
                    // Nếu tạo customer thất bại, xóa user vừa tạo
                    $userModel->delete($userId);
                    throw new Exception("Không thể tạo thông tin khách hàng.");
                }

                // Auto-login after registration
                $_SESSION['user_id'] = $userId;
                $_SESSION['customer_id'] = $customerId;
                $_SESSION['username'] = $data['username'];
                $_SESSION['full_name'] = $data['full_name'];

                // Redirect to intended page or home
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirectUrl = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    if (strpos($redirectUrl, '/shop_giay/') === 0) {
                        header('Location: ' . $redirectUrl);
                        exit();
                    }
                    $this->redirect($redirectUrl);
                }
                else {
                    $this->redirect('home/index');
                }
            }
            catch (Exception $e) {
                error_log("Registration error: " . $e->getMessage());
                $this->view('auth/register', ['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
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