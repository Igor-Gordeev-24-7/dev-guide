<?php
// publish_scheduled_posts.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Устанавливаем правильный часовой пояс
date_default_timezone_set('Europe/Moscow');

// Проверяем, запущена ли сессия
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// // Проверяем, авторизован ли пользователь
// if (!isset($_SESSION['id'])) {
//     // Если пользователь не авторизован, перенаправляем на главную страницу
//     header("Location: " . BASE_URL . 'index.php');
//     exit();
// }

// Подключаем файл конфигурации
include(__DIR__ . '/../../pass.php');

// Подключаем файл posts.php, используя SITE_ROOT
include(SITE_ROOT . '/app/controllers/posts.php');

// Подключаем файл db.php, используя константу SITE_ROOT
include(SITE_ROOT . '/app/database/db.php');

$postsAdmin = selectAllFromPostsAWithAdmin('posts', 'users');
test($postsAdmin);

$current_time = date('Y-m-d H:i:s');
$postsAdmin = selectAll('posts', ['is_scheduled' => true, 'scheduled_publish_date' => ['<=', $current_time]]);

if (empty($postsAdmin)) {
    echo "<pre>";
    print_r("No scheduled posts found for current time: " . $current_time);
    echo "</pre>";

    // Запись логов
    $log_file = SITE_ROOT . '/cron_log.txt';
    file_put_contents($log_file, 'No scheduled posts found for current time: ' . $current_time . "\n", FILE_APPEND);
} else {
    foreach ($postsAdmin as $post) {
        update('posts', $post['id'], ['status' => 1, 'is_scheduled' => false]);
    }

    // Запись логов
    $log_file = SITE_ROOT . '/cron_log.txt';
    file_put_contents($log_file, 'CRON job executed at ' . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
}