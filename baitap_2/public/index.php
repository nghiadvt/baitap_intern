<?php
session_start();
require_once('../app/controllers/AuthController.php');

$authController = new AuthController();

// Kiểm tra đăng nhập
if (!$authController->isLoggedIn()) {
    // Nếu chưa đăng nhập, điều hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Nếu đã đăng nhập, điều hướng đến trang dashboard
header("Location: dashboard.php");
exit();
