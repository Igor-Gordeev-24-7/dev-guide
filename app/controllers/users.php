<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Включите файлы конфигурации
include(ROOT_PATH . '/pass.php');
include(ROOT_PATH . '/app/database/db.php');

// echo "users подключен";

$errorMsg = [];
$users = selectAll('users');


// Универсальная функция для авторизации пользователя
function loginUser($user) {
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];

    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        header('Location: ' . BASE_URL . 'admin/posts/posts-index.php');
    } else {
        header('Location: ' . BASE_URL);
    }
    exit();
}

// Регистрация
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])) {
    $errorMsg = []; // Инициализация массива для ошибок

    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $passwordFirst = trim($_POST['password-first']);
    $passwordSecond = trim($_POST['password-second']);
    if(isset($_POST['g-recaptcha-response'])) {
        $google_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfYz34qAAAAALSClri5BxL-BlODejTmH0spAHqI&response=' . stripslashes($_POST['g-recaptcha-response']));
        $decoded_response = json_decode($google_response, true);
        if(!$decoded_response['success']) {
            array_push($errorMsg, 'Вы не прошли проверку Google Recaptcha');
        }
    }

    // Проверка на пустые поля
    if ($email === '') {
        array_push($errorMsg, 'Поле "Email" не должно быть пустым.');
    }

    if ($username === '') {
        array_push($errorMsg, 'Поле "Логин" не должно быть пустым.');
    }

    // Проверка длины логина
    if (mb_strlen($username, 'UTF8') < 3) {
        array_push($errorMsg, 'Логин не может быть короче 3-х символов.');
    }

    // Проверка длины паролей
    if ($passwordFirst === '' || $passwordSecond === '') {
        array_push($errorMsg, 'Пароль не должен быть пустым.');
    }

    // Проверка совпадения паролей
    if ($passwordFirst !== $passwordSecond) {
        array_push($errorMsg, 'Пароли не совпадают.');
    }

    // Проверка существования пользователя с таким email
    if (count($errorMsg) === 0) {
        $existence = selectOne('users', ['email' => $email]);

        if ($existence && isset($existence['email']) && $existence['email'] === $email) {
            array_push($errorMsg, 'Пользователь с такой почтой уже зарегистрирован.');
        }
    }

    // Если нет ошибок, создаем нового пользователя
    if (count($errorMsg) === 0) {
        $pass = password_hash($passwordSecond, PASSWORD_DEFAULT);

        // Заполняем массив $post данными
        $post = [
            'admin' => 0, // admin по умолчанию
            'username' => $username,
            'email' => $email,
            'password' => $pass
        ];

        $id = insert('users', $post);
        $user = selectOne('users', ['id' => $id]);

        // Очищаем поля
        $email = '';
        $username = '';

        // Используем универсальную функцию для авторизации
        loginUser($user);
    }
} else {
    $email = '';
    $username = '';
}

// Код для формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // test($_POST);
    // exit;

    // Проверка на пустые поля
    if ($email === '') {
        array_push($errorMsg, 'Поле "Email" не должно быть пустым.');
    }

    if ($password === '') {
        array_push($errorMsg, 'Поле "Пароль" не должно быть пустым.');
    }

    if(isset($_POST['g-recaptcha-response'])) {
        $google_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfYz34qAAAAALSClri5BxL-BlODejTmH0spAHqI&response=' . stripslashes($_POST['g-recaptcha-response']));
        $decoded_response = json_decode($google_response, true);
        if(!$decoded_response['success']) {
            array_push($errorMsg, 'Вы не прошли проверку Google Recaptcha');
        }
    }

    // Если нет ошибок, проверяем пользователя
    if (count($errorMsg) === 0) {
        $existence = selectOne('users', ['email' => $email]);

        if ($existence && password_verify($password, $existence['password'])) {
            loginUser($existence);
            exit();
        } else {
             array_push($errorMsg, 'Данные введены неверно.');
        }
    }
} else {
    $email = '';
}

// Код добаления пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-user'])) {

    $admin = 0;
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $passwordFirst = trim($_POST['password-first']);
    $passwordSecond = trim($_POST['password-second']);

    // Проверка на пустые поля
    if ($email === '') {
    array_push($errorMsg, 'Поле "Email" не должно быть пустым.');
    }

    if ($username === '') {
    array_push($errorMsg, 'Поле "Логин" не должно быть пустым.');
    }

    // // Проверка длины логина
    // Проверка длины логина
    if (mb_strlen($username, 'UTF8') < 3) { 
        array_push($errorMsg, 'Логин не может быть короче 3-х символов.'); 
    }

    // Проверка длины паролей 
    if ($passwordFirst === '' || $passwordSecond === '') { 
        array_push($errorMsg, 'Пароль не должен быть пустым.'); 
    }

    // Проверка совпадения паролей 
    if ($passwordFirst !== $passwordSecond) { 
        array_push($errorMsg, 'Пароли не совпадают.'); 
    }

    // Проверка существования пользователя с таким email 
    if (count($errorMsg) === 0) { 
        $existence = selectOne('users', ['email' => $email]);

        if ($existence && isset($existence['email']) && $existence['email'] === $email) {
            array_push($errorMsg, 'Пользователь с такой почтой уже зарегистрирован.');
        }
    }

    // Если нет ошибок, создаем нового пользователя
    if (count($errorMsg) === 0) {
        $pass = password_hash($passwordSecond, PASSWORD_DEFAULT);

        // Заполняем массив $post данными
        $post = [
            'admin' => $admin,
            'username' => $username,
            'email' => $email,
            'password' => $pass
        ];


        $id = insert('users', $post);
        $user = selectOne('users', ['id' => $id]);

        // Очищаем поля
        $email = '';
        $username = '';

        header('Location: ' . BASE_URL . 'admin/users/users-index.php');
    } 
} else {
    $email = '';
    $username = '';
}

// РЕДАКТИРОВАНИЕ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-user'])) {
    // Инициализация переменных
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password-first']);
    $admin = trim($_POST['category']); // 1 = Admin, 0 = User
    
    $errorMsg = []; // Массив для ошибок

    // Проверка на пустые поля
    if ($email === '') {
        array_push($errorMsg, 'Поле "Email" не должно быть пустым.');
    }
    if ($username === '') {
        array_push($errorMsg, 'Поле "Логин" не должно быть пустым.');
    }
    if ($admin === '') {
        array_push($errorMsg, 'Выберите роль пользователя.');
    }
    if (mb_strlen($username, 'UTF8') < 3) {
        array_push($errorMsg, 'Логин должен содержать не менее 3-х символов.');
    }

    // Если пароль был введен, хешируем его, иначе оставляем старый
    if ($password !== '') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Получаем текущие данные пользователя для получения его старого пароля
        $user = selectOne('users', ['id' => $_POST['id']]);
        $hashedPassword = $user['password'];
    }

    // Если ошибок нет, обновляем пользователя
    if (count($errorMsg) === 0) {
        // Заполняем массив $user данными
        $user = [
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword,
            'admin' => $admin  // Роль сохраняется как 1 (Admin) или 0 (User)
        ];

        // Обновление пользователя
        $id = $_POST['id'];
        update('users', $id, $user);

        // Перенаправление на страницу списка пользователей
        header("Location: " . BASE_URL . 'admin/users/users-index.php');
        exit(); // Завершаем выполнение скрипта
    }
}

// Получение данных пользователя для редактирования
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = selectOne('users', ['id' => $id]);

    // Передача данных из базы в переменные для подстановки в форму
    $email = $user['email'];
    $username = $user['username'];
    $admin = $user['admin']; // 1 = Admin, 0 = User
}

// Удаление пользователя
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    
    delete('users', $id);

    // Перенаправление на страницу списка пользователей
    header("Location: " . BASE_URL . 'admin/users/users-index.php');
    exit();
}