<?php
require_once('../../includes/db_connection.php');
require_once('../controllers/AuthController.php');
session_start();

$authController = new AuthController($conn);

if ($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $authController->login($email,$password);       
        }
    }
    $conn->close();
}
