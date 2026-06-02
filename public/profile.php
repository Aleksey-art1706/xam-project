<?php
require_once 'config.php';
$session = checkAuth();
$user_id = $_SESSION['user_id'];

$applications = mysqli_query($conn, "SELECT * FROM applications WHERE user_id = $user_id ORDER BY created_at DESC");

$reviews = mysqli_query($conn, "SELECT r.*, a.service_type FROM reviews r 
                                JOIN applications a ON r.application_id = a.id 
                                WHERE r.user_id = $user_id ORDER BY r.created_at DESC");
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Личный кабинет</title><link href="css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📋 Личный кабинет</h3>
        <div><a href="index.php" class="btn btn-secondary">← На главную</a> <a href="logout.php" class="btn btn-danger">Выйти</a></div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5>👤 Мои данные</h5>
        </div>
        <div class="card-body">
            <p><strong>ФИО:</strong> <?= htmlspecialchars($_SESSION['full_name']) ?></p>
            <p><strong>Логин:</strong> <?= htmlspecialchars($_SESSION['user_login']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user_email']) ?></p>
            <p><strong>Телефон:</strong> <?= htmlspecialchars(mysqli_fetch_assoc(mysqli_query($conn, "SELECT phone FROM users WHERE id=$user_id"))['phone']) ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5>📋 Мои заявки</h5>
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($applications) > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead><tr><th>ID</th><th>Услуга</th><th>Дата</th><th>Способ оплаты</th><th>Статус</th><th>Действие</th></tr></thead>
                    <tbody>
                    <?php while ($app = mysqli_fetch_assoc($applications)): ?>
                        <tr>
                            <td><?= $app['id'] ?></td>
                            <td><?= htmlspecialchars($app['service_type']) ?></td>
                            <td><?= $app['event_date'] ?></td>
                            <td><?= htmlspecialchars($app['payment_method']) ?></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if ($app['status'] == 'Новая') $badge = 'warning';
                                elseif ($app['status'] == 'Банкет назначен' || $app['status'] == 'Идет обучение') $badge = 'info';
                                elseif ($app['status'] == 'Банкет завершен' || $app['status'] == 'Обучение завершено') $badge = 'success';
                                ?>
                                <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($app['status']) ?></span>
                            </td>
                            <td>
                                <?php if ($app['status'] != 'Новая'): ?>
                                    <a href="add_review.php?app_id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-primary">✍️ Оставить отзыв</a>
                                <?php else: ?>
                                    <span class="text-muted">Ожидает подтверждения</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>У вас пока нет заявок. <a href="new_application.php">Создать заявку</a></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h5>⭐ Мои отзывы</h5>
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($reviews) > 0): ?>
                <?php while ($rev = mysqli_fetch_assoc($reviews)): ?>
                    <div class="border-bottom mb-2 pb-2">
                        <strong><?= htmlspecialchars($rev['service_type']) ?></strong>
                        <span class="text-warning"><?= str_repeat('★', $rev['rating']) ?></span>
                        <p><?= nl2br(htmlspecialchars($rev['review'])) ?></p>
                        <small class="text-muted"><?= $rev['created_at'] ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Отзывов пока нет. Оставьте отзыв после завершения услуги.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>