<?php
$hostname = 'localhost'; // Địa chỉ IP MySQL server
$username = 'root'; // Tên người dùng MySQL
$password = 'cms-8341'; // Mật khẩu MySQL
$database = 'baitap_intern'; // Tên cơ sở dữ liệu MySQL

// Tạo kết nối
$conn = new mysqli($hostname, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
} else {
    $GLOBALS['g_conn'] = $conn;
}
