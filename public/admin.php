<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_login']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['change_status']) && isset($_GET['status'])) {
    $app_id = $_GET['change_status'];
    $new_status = $_GET['status'];
    mysqli_query($conn, "UPDATE applications SET status='$new_status' WHERE id=$app_id");
    header('Location: admin.php');
    exit();
}

$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at DESC';
$allowed_sorts = ['created_at DESC', 'created_at ASC', 'event_date DESC', 'event_date ASC'];
if (!in_array($sort, $allowed_sorts)) $sort = 'created_at DESC';

$where = $status_filter ? "WHERE a.status = '$status_filter'" : "";
$applications = mysqli_query($conn, "SELECT a.*, u.login, u.full_name, u.phone 
                                     FROM applications a 
                                     JOIN users u ON a.user_id = u.id 
                                     $where 
                                     ORDER BY $sort");

$stats = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status='Новая' THEN 1 ELSE 0 END) as new_count,
    SUM(CASE WHEN status='Банкет назначен' OR status='Идет обучение' THEN 1 ELSE 0 END) as progress_count,
    SUM(CASE WHEN status='Банкет завершен' OR status='Обучение завершено' THEN 1 ELSE 0 END) as done_count
FROM applications"));
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Админ-панель</title><link href="css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h3>👑 Админ-панель</h3>
            <p>Вы: <strong><?= $_SESSION['user_login'] ?></strong> <a href="index.php" class="btn btn-sm btn-outline-light">🏠</a> <a href="logout.php" class="btn btn-sm btn-outline-danger">🚪</a></p>
        </div>
        <div class="card-body">

            <div class="row mb-4">
                <div class="col-md-3"><div class="alert alert-info text-center">📊 Всего: <?= $stats['total'] ?></div></div>
                <div class="col-md-3"><div class="alert alert-warning text-center">🆕 Новые: <?= $stats['new_count'] ?></div></div>
                <div class="col-md-3"><div class="alert alert-primary text-center">⏳ В работе: <?= $stats['progress_count'] ?></div></div>
                <div class="col-md-3"><div class="alert alert-success text-center">✅ Завершено: <?= $stats['done_count'] ?></div></div>
            </div>

            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <select name="status_filter" class="form-select">
                        <option value="">Все статусы</option>
                        <option value="Новая" <?= $status_filter == 'Новая' ? 'selected' : '' ?>>Новая</option>
                        <option value="Банкет назначен" <?= $status_filter == 'Банкет назначен' ? 'selected' : '' ?>>Банкет назначен</option>
                        <option value="Идет обучение" <?= $status_filter == 'Идет обучение' ? 'selected' : '' ?>>Идет обучение</option>
                        <option value="Банкет завершен" <?= $status_filter == 'Банкет завершен' ? 'selected' : '' ?>>Банкет завершен</option>
                        <option value="Обучение завершено" <?= $status_filter == 'Обучение завершено' ? 'selected' : '' ?>>Обучение завершено</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="sort" class="form-select">
                        <option value="created_at DESC" <?= $sort == 'created_at DESC' ? 'selected' : '' ?>>Сначала новые</option>
                        <option value="created_at ASC" <?= $sort == 'created_at ASC' ? 'selected' : '' ?>>Сначала старые</option>
                        <option value="event_date ASC" <?= $sort == 'event_date ASC' ? 'selected' : '' ?>>По дате события (возрастание)</option>
                        <option value="event_date DESC" <?= $sort == 'event_date DESC' ? 'selected' : '' ?>>По дате события (убывание)</option>
                    </select>
                </div>
                <div class="col-md-4"><button type="submit" class="btn btn-primary w-100">Применить фильтр</button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr><th>ID</th><th>Пользователь</th><th>Услуга</th><th>Дата события</th><th>Оплата</th><th>Статус</th><th>Действия</th></tr>
                    </thead>
                    <tbody>
                    <?php while ($app = mysqli_fetch_assoc($applications)): ?>
                        <tr>
                            <td><?= $app['id'] ?></td>
                            <td><?= htmlspecialchars($app['full_name']) ?><br><small><?= $app['phone'] ?></small></td>
                            <td><?= htmlspecialchars($app['service_type']) ?></td>
                            <td><?= $app['event_date'] ?></td>
                            <td><?= htmlspecialchars($app['payment_method']) ?></td>
                            <td>
                                <span class="badge bg-<?= $app['status'] == 'Новая' ? 'warning' : ($app['status'] == 'Банкет назначен' || $app['status'] == 'Идет обучение' ? 'info' : 'success') ?>">
                                    <?= $app['status'] ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <?php if ($app['status'] == 'Новая'): ?>
                                        <a href="?change_status=<?= $app['id'] ?>&status=<?= strpos($app['service_type'], 'зал') !== false ? 'Банкет назначен' : 'Идет обучение' ?>" class="btn btn-success">✅ Подтвердить</a>
                                        <a href="?change_status=<?= $app['id'] ?>&status=Отклонена" class="btn btn-danger">❌ Отклонить</a>
                                    <?php elseif ($app['status'] == 'Банкет назначен' || $app['status'] == 'Идет обучение'): ?>
                                        <a href="?change_status=<?= $app['id'] ?>&status=<?= strpos($app['service_type'], 'зал') !== false ? 'Банкет завершен' : 'Обучение завершено' ?>" class="btn btn-warning">🏁 Завершить</a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>