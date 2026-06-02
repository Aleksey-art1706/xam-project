<?php
require_once 'config.php';
$session = checkAuth();
$app_id = $_GET['app_id'];

$check = mysqli_query($conn, "SELECT * FROM applications WHERE id=$app_id AND user_id={$_SESSION['user_id']} AND status != 'Новая'");
if (mysqli_num_rows($check) == 0) {
    header('Location: profile.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = trim($_POST['review']);
    $rating = $_POST['rating'];
    
    mysqli_query($conn, "INSERT INTO reviews (user_id, application_id, review, rating) 
                         VALUES ({$_SESSION['user_id']}, $app_id, '$review', $rating)");
    header('Location: profile.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Оставить отзыв</title><link href="css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center mb-4">✍️ Оставить отзыв</h3>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Оценка</label>
            <select name="rating" class="form-select" required>
                <option value="5">★★★★★ (5)</option>
                <option value="4">★★★★☆ (4)</option>
                <option value="3">★★★☆☆ (3)</option>
                <option value="2">★★☆☆☆ (2)</option>
                <option value="1">★☆☆☆☆ (1)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Текст отзыва</label>
            <textarea name="review" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Отправить отзыв</button>
        <div class="text-center mt-3"><a href="profile.php">← Назад</a></div>
    </form>
</div>
</body>
</html>