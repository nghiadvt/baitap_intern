<?php
require_once('../controllers/AuthController.php');
require_once('../controllers/PostController.php');
require_once('../models/post.php');

$postController = new PostController($conn);

// Xử lý thêm bài viết mới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = 1; // Thay bằng ID người dùng thực tế

    if ($postController->addPost($title, $content, $user_id)) {
        echo "Thêm bài viết thành công!";
        header("location:dashboard.php");
    } else {
        echo "Thêm bài viết thất bại!";
    }
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