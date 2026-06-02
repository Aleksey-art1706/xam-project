<?php session_start(); if (isset($_SESSION['user_login'])) header('Location: index.php'); ?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Вход</title><link href="css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h3 class="text-center mb-4">Вход</h3>
            <?php if (isset($_GET['error'])) echo '<div class="alert alert-danger">Неверный логин или пароль</div>'; ?>
            <form action="login_handler.php" method="POST">
                <div class="mb-3"><label class="form-label">Логин</label><input type="text" name="login" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Пароль</label><input type="password" name="password" class="form-control" required></div>
                <button type="submit" class="btn btn-success w-100">Войти</button>
                <div class="text-center mt-3"><a href="register.php">Нет аккаунта? Зарегистрироваться</a></div>
            </form>
        </div>
    </div>
</div>
</body>
</html>