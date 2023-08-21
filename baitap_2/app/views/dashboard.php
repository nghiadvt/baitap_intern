<?php
session_start();

require_once('../controllers/AuthController.php');
require_once('../controllers/UserController.php');
require_once('../controllers/PostController.php');

$authController = new AuthController();
$userController = new UserController();
$postController = new PostController($conn);

// Kiểm tra đăng nhập
if (!$authController->isLoggedIn()) {
    // Nếu chưa đăng nhập, điều hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$user = $userController->getUserById($_SESSION['user_id']);

// Lấy danh sách bài viết của người dùng
$posts = $postController->getUserPosts($user->getId());
?>

<!-- Giao diện HTML cho trang dashboard -->
<?php include('../app/views/header.php'); ?>

<h1>Xin chào, <?php echo $user->getUsername(); ?>!</h1>
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