<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include(ROOT_PATH . '/pass.php');
require_once __DIR__ . '/../database/db.php';

$errorMsg = [];
$successMsg = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-img'])) {
    // Проверка на наличие изображения в форме
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // Получаем информацию о файле
        $imgTmpName = $_FILES['img']['tmp_name'];
        $imgName = basename($_FILES['img']['name']);  // Оригинальное имя файла
        $imgType = $_FILES['img']['type'];  // Тип файла
        $imgSize = $_FILES['img']['size'];  // Размер файла

        // Определение допустимых типов изображений
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        // Проверка типа файла
        if (!in_array($imgType, $allowedTypes)) {
            array_push($errorMsg, "Неверный тип файла. Допустимы только JPEG, PNG, GIF и WebP.");
        }

        // Проверка размера файла (максимум 5 MB)
        if ($imgSize > 5 * 1024 * 1024) {
            array_push($errorMsg, "Размер файла не должен превышать 5 MB.");
        }

        // Папка для хранения изображений
        $targetDir = "../../assets/uploads/";

        // Генерация уникального имени для изображения
        $imgNewName = uniqid() . '_' . $imgName;
        $targetFile = $targetDir . $imgNewName;

        // Если ошибок нет, выполняем загрузку
        if (empty($errorMsg)) {
            if (move_uploaded_file($imgTmpName, $targetFile)) {
                $imgPath = $targetFile;
                $title = $imgName;

                // Сохранение данных в базу данных (пример)
                // $query = "INSERT INTO images (title, img_path) VALUES (?, ?)";
                // $stmt = $pdo->prepare($query);
                // $stmt->execute([$title, $imgPath]);

                array_push($successMsg, "Изображение успешно загружено!");
            } else {
                array_push($errorMsg, "Ошибка при загрузке изображения.");
            }
        }
    } else {
        array_push($errorMsg, "Файл не выбран или произошла ошибка при загрузке.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {
    // Получаем имя изображения из POST-запроса
    $image = $_POST['image'];
    
    // Формируем полный путь к файлу
    $imagePath = IMAGES_DIR_PATH . $image;
    
    // Проверяем, существует ли файл
    if (file_exists($imagePath)) {
        // Пытаемся удалить файл
        if (unlink($imagePath)) {
            // echo "Файл $image удален успешно.";
            // После успешного удаления можно обновить страницу или перенаправить
            header("Location: images-index.php?message=Изображение удалено успешно");
            exit;
        } else {
            // echo "Ошибка при удалении файла.";
        }
    } else {
        // echo "Файл не существует.";
    }
}

?>