<?php
// Убедитесь, что ROOT_PATH определена
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
}

// Укажите путь к папке с изображениями
$directory = ROOT_PATH . '/assets/uploads';

// Проверка на существование директории
if (!is_dir($directory)) {
    $result = ['error' => 'Папка с изображениями не найдена.'];
} else {
    // Получаем все файлы из папки
    $files = array_diff(scandir($directory), array('..', '.'));

    // Фильтруем только изображения
    $images = array_filter($files, function($file) use ($directory) {
        $filePath = $directory . '/' . $file;
        return is_file($filePath) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
    });

    // Если изображений нет
    if (empty($images)) {
        $result = ['error' => 'Нет изображений в папке.'];
    } else {
        // Записываем список изображений в переменную
        $result = $images; // Простой массив изображений
    }
}