<?php
require('config.php');
if ($conn) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                session_start();
                // Đăng nhập thành công
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                header("Location: index.php"); // Chuyển hướng đến trang dashboard hoặc trang khác
            } else {
                // Sai mật khẩu
                echo "Sai mật khẩu!";
            }
        } else {
            // Không tìm thấy người dùng với email này
            echo "Không tìm thấy người dùng với email này!";
        }

        $stmt->close();
    }

    $conn->close();
}
