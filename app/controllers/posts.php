<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Подключаем файл конфигурации
include(SITE_ROOT . '/pass.php');

// Подключаем файл db.php, используя константу SITE_ROOT
include(SITE_ROOT . '/app/database/db.php');

// Инициализация переменных
$errorMsg = [];
$id = '';
$title = '';
$description = '';
$keywords = ''; // Добавляем переменную для keywords
$content = '';
$topic = '';
$img = '';

$topics = selectAll("topics");
$posts = selectAll('posts');
$postsAdmin = selectAllFromPostsAWithAdmin('posts', 'users');
$users = selectAll('users');

$userNames = [];
foreach ($users as $user) {
    $userNames[$user['id']] = $user['username'];
}

// Проверка, выполняется ли скрипт через cron-задачу
$isCron = php_sapi_name() == 'cli';

// Код для формы создания поста
if (!$isCron && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-post'])) {
    // Получаем текстовые данные
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $keywords = trim($_POST['keywords']); // Добавляем получение keywords
    $content = trim($_POST['content']);
    $postTopic = $_POST['topic'];
    $scheduled_publish_date = trim($_POST['scheduled_publish_date']); // Добавляем получение даты публикации

    // Проверяем, установлен ли чекбокс 'publish'
    $publish = isset($_POST['publish']) ? 1 : 0;

    // Проверка на ошибки в текстовых данных
    if ($title === '' || $content === '' || $description === '' || $keywords === '') {
        array_push($errorMsg, 'Не все поля заполнены!');
    }
    
    if (mb_strlen($title, 'UTF8') < 7) {
        array_push($errorMsg, 'Название статьи не может быть короче 7 символов');
    }

    // Проверка, выбрана ли категория
    if (empty($postTopic)) {
        array_push($errorMsg, 'Пожалуйста, выберите категорию для поста.');
    }

    // Если есть ошибки, возвращаемся к форме
    if (count($errorMsg) > 0) {
        // Здесь можно вывести ошибки или сделать что-то еще, например, вернуть форму с ошибками
        return; // Не продолжаем выполнение кода
    }

    // Добавляем проверку для изображения
    if (isset($_POST['existing_img']) && $_POST['existing_img'] !== '') {
        // Используется выбранное изображение
        $img = $_POST['existing_img'];
    } elseif (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // Загружается новое изображение
        $target_dir = "../../assets/uploads";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $img = basename($_FILES["img"]["name"]);
        } else {
            array_push($errorMsg, 'Ошибка при загрузке файла!');
        }
    } else {
        // Если изображение не загружено, используем либо текущее изображение, либо изображение по умолчанию
        $img = '../../assets/uploads/test2.jpg'; // Изображение по умолчанию
    }

    // Проверяем, пустое ли поле scheduled_publish_date
    if (empty($scheduled_publish_date)) {
        $scheduled_publish_date = null;
    }

    // Заполняем массив с данными для записи в БД
    $post = [
        'id_user' => $_SESSION['id'],
        'title' => $title,
        'description' => $description,
        'keywords' => $keywords, // Добавляем keywords
        'img' => $img, // Сохраняем путь к файлу в базу данных (новый или старый)
        'content' => $content,
        'status' => $publish,
        'id_topic' => $postTopic,
        'scheduled_publish_date' => $scheduled_publish_date, // Добавляем дату публикации
        'is_scheduled' => ($scheduled_publish_date !== null) ? 1 : 0, // Устанавливаем флаг is_scheduled
    ];

    // test($post);
    // test($_SESSION['id']);

    // Вставляем запись в таблице
    $postId = insert('posts', $post);

    // Перенаправляем пользователя на страницу с постами
    header("Location: " . BASE_URL . 'admin/posts/posts-index.php');
    exit();
}

// Получение данных поста по его id
if (!$isCron && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Получаем данные поста по id
    $post = selectOne('posts', ['id' => $id]);

    // Проверка, что результат не false
    if ($post !== false) {
        // Извлечение данных для редактирования
        $id = $post['id'];
        $title = $post['title'];
        $description = $post['description'];
        $keywords = $post['keywords']; // Добавляем keywords
        $content = $post['content'];
        $topic = $post['id_topic'];
        $img = $post['img'];
        $scheduled_publish_date = $post['scheduled_publish_date']; // Добавляем дату публикации
    } else {
        // Если пост не найден, можно обработать ошибку, например:
        // echo "Пост с таким ID не найден.";
    }
}

// Код для формы редактирования поста
if (!$isCron && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-post'])) {
    // Получаем текстовые данные
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $keywords = trim($_POST['keywords']); // Добавляем получение keywords
    $content = trim($_POST['content']);
    $postTopic = $_POST['topic'];
    $postId = $_POST['id']; // Получаем ID поста для редактирования
    $scheduled_publish_date = trim($_POST['scheduled_publish_date']); // Добавляем получение даты публикации

    // Проверяем, установлен ли чекбокс 'publish'
    $publish = isset($_POST['publish']) ? 1 : 0; // Добавляем инициализацию $publish

    // Проверка на ошибки в текстовых данных
    if ($title === '') {
        array_push($errorMsg, 'Поле "Название" не должно быть пустым.');
    }

    if ($description === '') {
        array_push($errorMsg, 'Поле "Описание" не должно быть пустым.');
    }

    if ($keywords === '') {
        array_push($errorMsg, 'Поле "Ключевые слова" не должно быть пустым.');
    }

    if (mb_strlen($title, 'UTF8') < 7) {
        array_push($errorMsg, 'Название статьи не может быть короче 7 символов.');
    }

    if ($content === '') {
        array_push($errorMsg, 'Поле "Содержание" не должно быть пустым.');
    }

    // Проверка, выбрана ли категория
    if (empty($postTopic)) {
        array_push($errorMsg, 'Пожалуйста, выберите категорию для поста.');
    }

    // Если ошибок нет, выполняем сохранение
    if (count($errorMsg) === 0) {
        // Добавляем проверку для изображения
        if (isset($_POST['existing_img']) && $_POST['existing_img'] !== '') {
            // Используется выбранное изображение
            $img = $_POST['existing_img'];
        } elseif (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            // Загружается новое изображение
            $target_dir = "../../assets/uploads";
            $target_file = $target_dir . basename($_FILES["img"]["name"]);

            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $img = basename($_FILES["img"]["name"]);
            } else {
                array_push($errorMsg, 'Ошибка при загрузке файла!');
            }
        } else {
            // Если изображение не загружено, оставляем старое
            $img = $_POST['current_img']; // Используем старое изображение
        }

        // Проверяем, пустое ли поле scheduled_publish_date
        if (empty($scheduled_publish_date)) {
            $scheduled_publish_date = null;
        }

        // Если ошибок по загрузке файла нет, выполняем обновление данных
        if (count($errorMsg) === 0) {
            // Обновляем данные поста в базе данных
            $post = [
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords, // Добавляем keywords
                'img' => $img, // Используем новый или старый путь к изображению
                'content' => $content,
                'status' => $publish, // Используем переменную $publish
                'id_topic' => $postTopic,
                'scheduled_publish_date' => $scheduled_publish_date, // Добавляем дату публикации
                'is_scheduled' => ($scheduled_publish_date !== null) ? 1 : 0, // Устанавливаем флаг is_scheduled
            ];

            // Выполняем обновление записи в базе данных
            update('posts', $postId, $post);

            // Перенаправляем пользователя на страницу с постами
            header("Location: " . BASE_URL . 'admin/posts/posts-index.php');
            exit();
        }
    }
}

// Изменение статуса публикации поста
if (!$isCron && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id']; // Получаем ID поста
    $status = $_GET['status']; // Получаем новый статус

    // Обновляем статус поста в базе данных
    update('posts', $id, ['status' => $status]);

    // Перенаправляем обратно на страницу с постами
    header("Location: " . BASE_URL . 'admin/posts/posts-index.php');
    exit();
}

// Удаление поста
if (!$isCron && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];

    // Вызов функции delete для удаления записи из таблицы 'posts'
    delete('posts', $id);

    // Перенаправление на страницу с постами после удаления
    header("Location: " . BASE_URL . 'admin/posts/posts-index.php');
    exit();
}