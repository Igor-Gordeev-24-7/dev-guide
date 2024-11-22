<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include(ROOT_PATH . '/pass.php');
require_once __DIR__ . '/../database/db.php';

// Инициализация переменных
$errorMsg = [];
$name = '';
$description = '';
$keywords = ''; // Новая переменная
$topics = selectAll("topics");

// Код для формы создания категории
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-create'])) {

    // Сохраняем значения из формы
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $keywords = trim($_POST['keywords']); // Новое поле

    // Проверки на ошибки
    if ($name === '') {
        array_push($errorMsg, 'Поле "Название" не должно быть пустым.');
    }

    if ($description === '') {
        array_push($errorMsg, 'Поле "Содержание" не должно быть пустым.');
    }

    if ($keywords === '') {
        array_push($errorMsg, 'Поле "Ключевые слова" не должно быть пустым.');
    }

    if (mb_strlen($name, 'UTF8') < 3) {
        array_push($errorMsg, 'Название категории не может быть короче 3-х символов.');
    }

    $existence = selectOne('topics', ['name' => $name]);

    // Проверка на существование записи
    if ($existence !== false && isset($existence['name']) && $existence['name'] === $name) {
        array_push($errorMsg, 'Категория с таким названием уже есть в базе.');
    }

    // Если ошибок нет, добавляем категорию
    if (count($errorMsg) === 0) {
        // Заполняем массив $topic данными
        $topic = [
            'name' => $name,
            'description' => $description,
            'keywords' => $keywords, // Новое поле
        ];

        $id = insert('topics', $topic);
        header("Location: " . BASE_URL . 'admin/topics/topics-index.php');
        exit();
    }
}

// Получение данных категории
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectOne('topics', ['id' => $id]);

    // Получаем данные категории
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
    $keywords = $topic['keywords']; // Новое поле
}

// Код для формы редактирования категории
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-edit'])) {

    // Сохраняем значения из формы
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $keywords = trim($_POST['keywords']); // Новое поле

    // Проверки на ошибки
    if ($name === '') {
        array_push($errorMsg, 'Поле "Название" не должно быть пустым.');
    }

    if ($description === '') {
        array_push($errorMsg, 'Поле "Содержание" не должно быть пустым.');
    }

    if ($keywords === '') {
        array_push($errorMsg, 'Поле "Ключевые слова" не должно быть пустым.');
    }

    if (mb_strlen($name, 'UTF8') < 3) {
        array_push($errorMsg, 'Название категории не может быть короче 3-х символов.');
    }

    // Если ошибок нет, обновляем категорию
    if (count($errorMsg) === 0) {
        // Заполняем массив $topic данными
        $topic = [
            'name' => $name,
            'description' => $description,
            'keywords' => $keywords, // Новое поле
        ];

        $id = $_POST['id'];
        update('topics', $id, $topic);

        header("Location: " . BASE_URL . 'admin/topics/topics-index.php');
        exit();
    }
}

// Удаление категории
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {

    $id = $_GET['del_id'];
    
    // Вызов функции delete для удаления записи из таблицы 'topics'
    delete('topics', $id);

    header("Location: " . BASE_URL . 'admin/topics/topics-index.php');
    exit();
}