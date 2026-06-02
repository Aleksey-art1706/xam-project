<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $birth_date = !empty($_POST['birth_date']) ? $_POST['birth_date'] : null;

    if (empty($login) || empty($email) || empty($pass) || empty($full_name) || empty($phone)) {
        header('Location: register.php?error=empty');
        exit();
    }

    if (!validateLogin($login)) {
        header('Location: register.php?error=login_short');
        exit();
    }

    if (!validatePassword($pass)) {
        header('Location: register.php?error=password_short');
        exit();
    }

    $check = mysqli_query($conn, "SELECT * FROM users WHERE login='$login' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $existing = mysqli_fetch_assoc($check);
        if ($existing['login'] == $login) {
            header('Location: register.php?error=login_exists');
        } else {
            header('Location: register.php?error=email_exists');
        }
        exit();
    }

    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (login, email, password, full_name, phone, birth_date) 
            VALUES ('$login', '$email', '$hashed', '$full_name', '$phone', " . ($birth_date ? "'$birth_date'" : "NULL") . ")";

    if (mysqli_query($conn, $sql)) {
        session_start();
        $_SESSION['user_login'] = $login;
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin'] = 0;
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['full_name'] = $full_name;
        header('Location: index.php');
        exit();
    } else {
        echo 'Ошибка: ' . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>