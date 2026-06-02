<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_type = $_POST['service_type'];
    $event_date = $_POST['event_date'];
    $payment_method = $_POST['payment_method'];

    $sql = "INSERT INTO applications (user_id, service_type, event_date, payment_method, status) 
            VALUES ('$user_id', '$service_type', '$event_date', '$payment_method', 'Новая')";

    if (mysqli_query($conn, $sql)) {
        header('Location: new_application.php?success=1');
    } else {
        echo 'Ошибка: ' . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>