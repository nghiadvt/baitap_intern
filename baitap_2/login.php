<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập</title>
</head>

<body>
    <?php session_start();
    if (isset($_SESSION['login_error'])) : ?>
        <p style="color: red;"><?php echo $_SESSION['login_error']; ?></p>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <h2>Đăng nhập</h2>
    <form action="login_process.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Đăng nhập">
    </form>
</body>

</html>