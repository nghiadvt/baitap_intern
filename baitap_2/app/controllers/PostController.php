<?php
require_once('../models/Post.php');
require_once('../../includes/db_connection.php');
require_once('../traits/CRUDTrait.php');

class PostController
{
    use CRUDTrait;

    protected $postModel;
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->postModel = new Post($conn);
    }

    public function addPost($data)
    {
        $errors = [];
        if ($this->postModel->addPost($data)) {
            $errors[] = ['message' => "Thêm bài viết thành công", 'color' => "green"];
        } else {
            $errors[] = ['message' => "Thêm bài viết thất bại", 'color' => "red"];
        }
        $_SESSION['errors'] = $errors;
        header("Location: dashboard.php"); // Chuyển hướng về trang chính
        exit();
    }

    public function getUserPosts($user_id)
    {
        return $this->postModel->getPostsByUserId($user_id);
    }

    public function deletePost($id)
    {
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true; // Xóa bài viết thành công
        }
        return false; // Xóa bài viết thất bại hoặc không có kết nối
    }
}
