<?php
session_start();
require_once 'config.php';

$login = $_POST['login'];
$pass = $_POST['password'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE login='$login'");
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['user_login'] = $user['login'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    
    if ($user['is_admin'] == 1) {
        header('Location: admin.php');
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: login.php?error=1');
}
exit();
?>