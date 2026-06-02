<?php require_once 'config.php'; $session = checkAuth(); ?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Новая заявка</title><link href="css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-4" style="max-width: 600px;">
    <h3 class="text-center mb-4">📝 Оформление заявки</h3>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">✅ Заявка успешно создана! Ожидайте подтверждения администратора.</div>
    <?php endif; ?>

    <form action="new_application_handler.php" method="POST">
        <div class="mb-3">
            <label class="form-label">🏢 Выберите услугу</label>
            <select name="service_type" class="form-select" required>
                <option value="">-- Выберите --</option>
                <!-- Для варианта "Банкетам.Нет" -->
                <option value="Банкетный зал">Банкетный зал</option>
                <option value="Ресторан">Ресторан</option>
                <option value="Летняя веранда">Летняя веранда</option>
                <option value="Закрытая веранда">Закрытая веранда</option>
                <!-- Для варианта "Водить.РФ" -->
                <option value="Катер">Катер</option>
                <option value="Круизный лайнер">Круизный лайнер</option>
                <option value="Яхта">Яхта</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">📅 Дата мероприятия/начала обучения</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">💳 Способ оплаты</label>
            <select name="payment_method" class="form-select" required>
                <option value="Наличные">Наличные</option>
                <option value="Банковская карта">Банковская карта</option>
                <option value="Безналичный расчёт">Безналичный расчёт</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Отправить заявку</button>
        <div class="text-center mt-3"><a href="index.php">← На главную</a></div>
    </form>
</div>
</body>
</html>