<?php
require_once('../models/post.php');
require_once('../includes/db_connection.php');

class PostController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getUserPosts($user_id)
    {

        $sql = "SELECT * FROM posts WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $userPosts = [];
        while ($row = $result->fetch_assoc()) {
            $userPosts[] = new Post($row['id'], $row['title'], $row['content']);
        }

        return $userPosts;
    }

    public function getPostById($id)
    {
        // Lấy thông tin bài viết theo ID từ cơ sở dữ liệu
        // (Sử dụng các hàm xử lý dữ liệu từ model)
        return $post;
    }

    public function createPost($title, $content)
    {
        // Tạo bài viết mới và lưu vào cơ sở dữ liệu
        // (Sử dụng các hàm xử lý dữ liệu từ model)
        return $success;
    }

    public function addPost($title, $content, $user_id)
    {
        $sql = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $user_id);

        if ($stmt->execute()) {
            return true; // Thêm bài viết thành công
        } else {
            return false; // Thêm bài viết thất bại
        }
    }

    public function updatePost($id, $title, $content)
    {
        // Cập nhật thông tin bài viết theo ID trong cơ sở dữ liệu
        // (Sử dụng các hàm xử lý dữ liệu từ model)
        return $success;
    }

    public function deletePost($id)
    {
        // Xóa bài viết theo ID từ cơ sở dữ liệu
        // (Sử dụng các hàm xử lý dữ liệu từ model)
        return $success;
    }
}
