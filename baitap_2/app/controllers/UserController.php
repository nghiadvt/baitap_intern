<?php

require_once('../models/user.php');
require_once('../../includes/db_connection.php');

class UserController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserById($id)
    {
        $sql = "SELECT id, username, password FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $password = $row['password'];

            return new User($id, $username, $password);
        } else {
            // Không tìm thấy người dùng với ID này
            return null;
        }
        $stmt->close();
    }
}
