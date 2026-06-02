<?php
$host = 'MySQL-8.4';
$user = 'root';
$password = '';
$database = 'exam_db';

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die('Ошибка подключения: ' . mysqli_connect_error());
}

function checkAuth() {
    session_start();
    if (!isset($_SESSION['user_login'])) {
        header('Location: login.php');
        exit();
    }
    return $_SESSION;
}

function checkAdmin() {
    session_start();
    if (!isset($_SESSION['user_login']) || $_SESSION['is_admin'] != 1) {
        header('Location: login.php');
        exit();
    }
    return $_SESSION;
}

function validateLogin($login) {
    if (strlen($login) < 6) return false;
    if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) return false;
    return true;
}

function validatePassword($password) {
    return strlen($password) >= 8;
}
?>