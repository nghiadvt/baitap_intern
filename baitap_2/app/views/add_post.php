<?php
session_start();

require_once('../controllers/AuthController.php');
require_once('../controllers/PostController.php');
require_once('../models/Post.php');

$authController = new AuthController($conn);
$postController = new PostController($conn);

if (!$authController->isLoggedIn()) {
    // Nếu chưa đăng nhập, điều hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
// Xử lý thêm bài viết mới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'user_id' => $user_id
    ];
    $postController = new PostController($conn);
    $postController->addPost($data);
}
?>

<!-- Form để thêm bài viết -->
<form method="post">
    <label for="title">Tiêu đề:</label>
    <input type="text" name="title" required><br>

    <label for="content">Nội dung:</label>
    <textarea name="content" required></textarea><br>

    <input type="submit" value="Thêm bài viết">
</form>