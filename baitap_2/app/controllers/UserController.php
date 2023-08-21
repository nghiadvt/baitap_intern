<?php

require_once('../models/user.php');

class UserController
{
    public function getUserById($id)
    {
        // Lấy thông tin người dùng theo ID từ cơ sở dữ liệu
        // (Sử dụng các hàm xử lý dữ liệu từ model)
        // Trong ví dụ này, giả sử người dùng có ID cố định là 1
        return new User(1, 'admin', 'hashed_password');
    }
}
