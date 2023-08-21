<?php
session_start();
require_once('../app/controllers/AuthController.php');

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $authController->login($username, $password);

    if ($user) {
        // Đăng nhập thành công, lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $user->getId();
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Đăng nhập không thành công.";
    }
}
?>

<!-- Giao diện HTML cho trang đăng nhập -->
<?php include('../app/views/header.php'); ?>

<h1>Đăng nhập</h1>
<form method="POST">
    <label for="username">Tên đăng nhập:</label>
    <input type="text" name="username" id="username" required><br>
    <label for="password">Mật khẩu:</label>
    <input type="password" name="password" id="password" required><br>
    <button type="submit">Đăng nhập</button>
</form>
<?php include('../app/views/footer.php'); ?>