<?php

require_once('../models/user.php');
require_once('../../includes/db_connection.php');

class AuthController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password)
    {
        session_start();

        // Xử lý đăng nhập
        // (Sử dụng các hàm xử lý dữ liệu từ model)

        if ($this->conn) {
            $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($password, $hashedPassword)) {
                    // Đăng nhập thành công
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    // Đăng nhập thành công, trả về đối tượng User tương ứng
                    // return new User($row['id'], $email, $password);

                    header("Location: dashboard.php"); // Chuyển hướng đến trang dashboard hoặc trang khác
                } else {
                    // Đăng nhập thất bại, gửi thông báo lỗi
                    $_SESSION["login_error"] = "Mật khẩu không chính xáac.";
                }
            } else {
                // Không tìm thấy người dùng với email này
                $_SESSION["login_error"] = "Người dùng không tồn tại!";
            }
            $stmt->close();
        }
        header("Location: login.php");
        exit();
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
