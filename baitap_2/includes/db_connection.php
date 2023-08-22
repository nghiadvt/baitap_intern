<?php

$hostname = 'localhost';
$username = 'root';
$password = 'cms-8341';
$database = 'baitap_intern';

// Tạo kết nối
$conn = new mysqli($hostname, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}
