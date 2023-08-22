<?php
session_start();

require_once('../controllers/AuthController.php');
require_once('../controllers/UserController.php');
require_once('../controllers/PostController.php');

$authController = new AuthController($conn);
$userController = new UserController($conn);
$postController = new PostController($conn);

// Kiểm tra đăng nhập
if (!$authController->isLoggedIn()) {
    // Nếu chưa đăng nhập, điều hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];
$postController = new PostController($conn);
$posts = $postController->getUserPosts($user_id);

include('../views/header.php');
// Hiển thị thông báo thành công nếu có
if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo '<div style="color: ' . $error['color'] . ';">' . $error['message'] . '</div>';
    }
    unset($_SESSION['errors']); // Xóa session sau khi đã hiển thị
}
?>
<table id="dataTable">
    <tr>
        <th>STT</th>
        <th>Title</th>
        <th>Content</th>
        <th>Action</th>
    </tr>
    <?php $stt = 1;

    foreach ($posts as $post) { ?>
        <tr>
            <td><?php echo $stt++; ?></td>
            <td><?php echo $post['title']; ?></td>
            <td><?php echo $post['content']; ?></td>
            <td>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>">Sửa</a>
                <a href="delete_post.php?id=<?php echo $post['id']; ?>">Xóa</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include('../views/footer.php'); ?>