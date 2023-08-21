<?php

require_once('../models/user.php');

class AuthController
{
    public function login($username, $password)
    {
        // Xử lý đăng nhập
        // (Sử dụng các hàm xử lý dữ liệu từ model)

        // Tạm thời, giả sử có một người dùng có tên đăng nhập và mật khẩu cố định
        $fixedUsername = 'admin';
        $fixedPassword = password_hash('password', PASSWORD_DEFAULT);

        if ($username === $fixedUsername && password_verify($password, $fixedPassword)) {
            // Đăng nhập thành công, trả về đối tượng User tương ứng
            return new User(1, $fixedUsername, $fixedPassword);
        } else {
            // Đăng nhập thất bại
            return false;
        }
    }

    public function logout()
    {
        // Xử lý đăng xuất
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function isLoggedIn()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        return isset($_SESSION['user_id']);
    }
}
