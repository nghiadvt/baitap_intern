<?php
require_once('../app/controllers/AuthController.php');
require_once('../app/controllers/PostController.php');

$authController = new AuthController();
$postController = new PostController();

// Kiểm tra đăng nhập
if (!$authController->isLoggedIn()) {
    // Nếu chưa đăng nhập, điều hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy danh sách bài viết
$posts = $postController->getAllPosts();
?>

<!-- Giao diện HTML cho trang quản lý bài viết -->
<?php include('../app/views/header.php'); ?>

<h1>Quản lý bài viết</h1>
<a href="add_post.php">Thêm bài viết mới</a>
<table>
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Nội dung</th>
        <th>Tùy chọn</th>
    </tr>
    <?php foreach ($posts as $post) : ?>
        <tr>
            <td><?php echo $post->getId(); ?></td>
            <td><?php echo $post->getTitle(); ?></td>
            <td><?php echo $post->getContent(); ?></td>
            <td>
                <a href="edit_post.php?id=<?php echo $post->getId(); ?>">Sửa</a>
                <a href="delete_post.php?id=<?php echo $post->getId(); ?>">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include('../app/views/footer.php'); ?>