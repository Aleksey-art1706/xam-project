<?php require_once 'config.php'; $session = checkAuth(); ?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Главная</title><link href="css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <div class="text-center mb-4">
        <h3>Привет, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['user_login']) ?>! ✅</h3>
        <a href="profile.php" class="btn btn-info">📋 Личный кабинет</a>
        <a href="new_application.php" class="btn btn-primary">📝 Новая заявка</a>
        <?php if ($_SESSION['is_admin'] == 1): ?>
            <a href="admin.php" class="btn btn-warning">👑 Админ-панель</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-danger">🚪 Выйти</a>
    </div>

    <div id="slider" class="carousel slide mx-auto" data-bs-ride="carousel" style="max-width: 600px;">
        <div class="carousel-inner rounded shadow">
            <div class="carousel-item active"><img src="img/slide1.jpg" class="d-block w-100" alt=""></div>
            <div class="carousel-item"><img src="img/slide2.jpg" class="d-block w-100" alt=""></div>
            <div class="carousel-item"><img src="img/slide3.jpg" class="d-block w-100" alt=""></div>
            <div class="carousel-item"><img src="img/slide4.jpg" class="d-block w-100" alt=""></div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>