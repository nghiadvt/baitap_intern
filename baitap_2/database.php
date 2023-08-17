<?php
require('config.php');
if ($conn) {
    $dbname = 'baitap_intern';
    // Drop all tables in the database
    $conn->query("SET FOREIGN_KEY_CHECKS = 0"); // Disable foreign key checks temporarily
    $result = $conn->query("SHOW TABLES");
    while ($table = $result->fetch_assoc()) {
        $tableName = $table["Tables_in_" . $dbname];
        $conn->query("DROP TABLE $tableName");
    }
    $conn->query("SET FOREIGN_KEY_CHECKS = 1"); // Enable foreign key checks again


    // Câu lệnh SQL để tạo bảng users
    $sql_users = "CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";

    // Câu lệnh SQL để tạo bảng posts với khóa ngoại tham chiếu đến bảng users
    $sql_posts = "CREATE TABLE posts (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    // Thực hiện câu lệnh tạo bảng users
    if ($conn->query($sql_users) === TRUE) {
        echo "Tạo bảng users thành công!<br>";
        $password = password_hash("password", PASSWORD_DEFAULT); // mật khẩu : password
        $sampleData = [
            ['username' => 'admin', 'email' => 'admin@gmail.com', 'password' => $password],
            ['username' => 'user', 'email' => 'user@gmail.com', 'password' => $password],
            // Thêm các dữ liệu mẫu khác tại đây
        ];

        foreach ($sampleData as $data) {
            $email = $data['email'];
            $password = $data['password'];
            $username = $data['username'];

            // Thực hiện truy vấn để chèn dữ liệu
            $insertQuery = "INSERT INTO users (username,email, password) VALUES ('$username','$email', '$password')";
            if ($conn->query($insertQuery) === TRUE) {
                echo "Inserted user with email: $email<br>";
            } else {
                echo "Error inserting user with email: $email - " . $conn->error . "<br>";
            }
        }
    } else {
        echo "Lỗi khi tạo bảng users: " . $conn->error . "<br>";
    }

    // Thực hiện câu lệnh tạo bảng posts
    if ($conn->query($sql_posts) === TRUE) {
        echo "Tạo bảng posts thành công!<br>";
    } else {
        echo "Lỗi khi tạo bảng posts: " . $conn->error . "<br>";
    }

    // Đóng kết nối
    $conn->close();
}
