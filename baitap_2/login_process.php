<?php
require('config.php');
if ($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        echo $email . $password;
        die();
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        session_start();
        if ($result->num_rows > 0) {
            // $user = $result->fetch_assoc();

            while ($row = mysqli_fetch_array($result)) {
                if (password_verify($password, $row["password"])) {
                    //return true;  
                    $_SESSION["username"] = $username;
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user_email"] = $user["email"];
                    // header("location:entry.php");
                    header("Location: dashboard.php");
                } else {
                    //return false;  
                    // echo '<script>alert("Wrong User Details")</script>';
                    $_SESSION["login_error"] = "Email hoặc mật khẩu không đúng!";
                    header("Location: login.php");
                }
            }
        } else {
            $_SESSION["login_error"] = "Email hoặc mật khẩu không đúng!";
            header("Location: login.php");
        }
    }

    $conn->close();
}
