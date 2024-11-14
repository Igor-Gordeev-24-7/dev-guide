<?php 
    // Проверяем, определены ли константы, и только если они не определены, объявляем их
    if (!defined('SITE_ROOT')) {
        define('SITE_ROOT', __DIR__); 
    }

    if (!defined('BASE_URL')) {
        define('BASE_URL', 'https://dev-guide.ru/');
    }

    if (!defined('ROOT_PATH')) {
        define('ROOT_PATH', realpath(dirname(__FILE__)));
    }

    // Определяем полный путь до изображений
    if (!defined('IMAGE_PATH')) {
        define('IMAGE_PATH', BASE_URL . 'assets/uploads/');
    }
    
    if (!defined('IMAGES_DIR_PATH')) {
        define('IMAGES_DIR_PATH', realpath(dirname(__FILE__)) . '/assets/uploads/');
    }
?>