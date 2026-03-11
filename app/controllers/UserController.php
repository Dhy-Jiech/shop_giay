<?php

class UserController extends Controller
{

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }

        $userModel = $this->model('User');
        $orderModel = $this->model('Order');

        $userId = $_SESSION['user_id'];
        $user = $userModel->findById($userId);
        $orders = $orderModel->getByUserId($userId);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address']),
            ];

            if ($userModel->updateProfile($userId, $data)) {
                $success = "Cập nhật thông tin thành công!";
                $user = $userModel->findById($userId);
                $_SESSION['full_name'] = $user['full_name'];
            }
            else {
                $error = "Cập nhật thất bại, vui lòng thử lại.";
            }

            $this->view('user/profile', [
                'user' => $user,
                'orders' => $orders,
                'success' => $success ?? null,
                'error' => $error ?? null,
                'title' => 'Trang cá nhân - Đớ Store'
            ]);
            return;
        }

        $this->view('user/profile', [
            'user' => $user,
            'orders' => $orders,
            'title' => 'Trang cá nhân - Đớ Store'
        ]);
    }
}