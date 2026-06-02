<?php
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-text { color: red; font-size: 0.8rem; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h3 class="text-center mb-4">Регистрация</h3>

            <?php if ($error == 'login_exists'): ?>
                <div class="alert alert-danger">❌ Такой логин уже существует!</div>
            <?php elseif ($error == 'email_exists'): ?>
                <div class="alert alert-danger">❌ Такой email уже зарегистрирован!</div>
            <?php elseif ($error == 'login_short'): ?>
                <div class="alert alert-danger">❌ Логин должен содержать минимум 6 символов (латиница, цифры)!</div>
            <?php elseif ($error == 'password_short'): ?>
                <div class="alert alert-danger">❌ Пароль должен содержать минимум 8 символов!</div>
            <?php elseif ($error == 'empty'): ?>
                <div class="alert alert-danger">❌ Заполните все поля!</div>
            <?php endif; ?>

            <form action="register_handler.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">👤 Логин</label>
                    <input type="text" name="login" class="form-control" required>
                    <small class="text-muted">Латинские буквы и цифры, минимум 6 символов</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">📧 Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">🔒 Пароль</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">Минимум 8 символов</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">👨 ФИО</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">📞 Телефон</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">🎂 Дата рождения</label>
                    <input type="date" name="birth_date" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                <div class="text-center mt-3">
                    <a href="login.php">Уже есть аккаунт? Войти</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>