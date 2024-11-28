<?php
// Проверяем, запущена ли сессия
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['id'])) {
    // Если пользователь не авторизован, перенаправляем на главную страницу
    header("Location: " . BASE_URL . 'index.php');
    exit();
}
?>