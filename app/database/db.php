<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// echo "db подключен";

if (!function_exists('displayError')) {
    function displayError($error) {
        echo "<div style='color: red; font-weight: bold;'>";
        echo "Ошибка: " . htmlspecialchars($error->getMessage());
        echo "<br>Код ошибки: " . htmlspecialchars($error->getCode());
        echo "<br>Стек вызовов: <pre>" . htmlspecialchars($error->getTraceAsString()) . "</pre>";
        echo "</div>";
    }
}

function test($value){
    echo "<pre>";
    print_r($value); // выводим данные
    echo "</pre>";
};

/**
 * Проверяет наличие ошибок после выполнения SQL-запроса.
 *
 * @param PDOStatement $query Объект PDOStatement, который содержит выполненный запрос.
 * @return bool Возвращает true, если ошибок нет, иначе завершает выполнение скрипта.
 */
function dbCheckError($query) {
    // Получаем информацию об ошибках, если они произошли
    $errInfo = $query->errorInfo();

    // Проверяем наличие ошибок
    if ($errInfo[0] !== PDO::ERR_NONE) {
        // Если есть ошибка, выводим сообщение об ошибке
        displayError(new Exception($errInfo[2], $errInfo[0])); // Передаем ошибку в displayError
        exit(); // Завершаем выполнение скрипта
    }

    // Если ошибок нет, возвращаем true
    return true;
}

/**
 * Функция для получения всех записей из указанной таблицы базы данных.
 *
 * @param string $table Имя таблицы, из которой нужно получить данные.
 * @return array Массив всех записей из таблицы.
 */
function selectAll($table, $params = []) {
    // Делаем переменную $pdo доступной в функции
    global $pdo;

    // Формируем SQL-запрос для выбора всех данных из указанной таблицы
    $sql = "SELECT * FROM $table";

    // Проверяем, есть ли параметры для фильтрации
    if (!empty($params)) {
        $i = 0; // Счетчик для определения, первый ли это параметр
        foreach ($params as $key => $value) {
            // Если значение не числовое, оборачиваем его в кавычки
            if (!is_numeric($value)) {
                $value = "'".$value."'";
            }

            // Если это первый элемент, используем WHERE, иначе - AND
            if ($i === 0) {
                $sql .= " WHERE $key = $value"; // Исправлено
            } else {
                $sql .= " AND $key = $value"; // Исправлено
            }
            $i++; // Увеличиваем счетчик
        }
    }
    // Подготавливаем запрос
    $query = $pdo->prepare($sql);

    // Выполняем подготовленный запрос
    $query->execute();

    // Проверяем наличие ошибок
    dbCheckError($query);

    // Возвращаем все записи в виде ассоциативного массива
    return $query->fetchAll();
}

// Запрос на получение строки с выбранной таблицы
function selectOne($table, $params = []) {
    // Делаем переменную $pdo доступной в функции
    global $pdo;

    // Формируем SQL-запрос для выбора всех данных из указанной таблицы
    $sql = "SELECT * FROM $table";

    // Проверяем, есть ли параметры для фильтрации
    if (!empty($params)) {
        $i = 0; // Счетчик для определения, первый ли это параметр
        foreach ($params as $key => $value) {
            // Если значение не числовое, оборачиваем его в кавычки
            if (!is_numeric($value)) {
                $value = "'".$value."'";
            }

            // Если это первый элемент, используем WHERE, иначе - AND
            if ($i === 0) {
                $sql .= " WHERE $key = $value"; // Исправлено
            } else {
                $sql .= " AND $key = $value"; // Исправлено
            }
            $i++; // Увеличиваем счетчик
        }
    }

    // Ограничиваем выборку до одной записи
    // $sql .= " LIMIT 1";

    // Подготавливаем запрос
    $query = $pdo->prepare($sql);

    // Выполняем подготовленный запрос
    $query->execute();

    // Проверяем наличие ошибок
    dbCheckError($query);

    // Возвращаем первую запись в виде ассоциативного массива
    return $query->fetch();
}

$param = [
    'admin' => '0',
    'password' => '55555',
    'email' => '11111111111@mail.ru',
];

// Вставка строки в таблицу
function insert($table, $params) {
    // Подключение глобальной переменной $pdo, представляющей подключение к базе данных
    global $pdo;

    // Переменные для формирования частей SQL-запроса
    $columns = '';        // Для имен столбцов
    $placeholders = '';   // Для плейсхолдеров значений (например, :username)
    $valuesForDisplay = ''; // Для отображения реальных данных (используется только для вывода на экран)
    $i = 0; // Счетчик для правильной расстановки запятых

    // Проходим по каждому элементу массива $params
    foreach ($params as $key => $value) {
        if ($i == 0) {
            // Для первого элемента не добавляем запятые
            $columns .= $key;  // Добавляем имя столбца (например, username)
            $placeholders .= ':' . $key;  // Добавляем плейсхолдер (например, :username)
            $valuesForDisplay .= "'" . $value . "'";  // Добавляем реальное значение для вывода (например, 'JohnDoe')
        } else {
            // Для всех остальных элементов добавляем запятые перед именами столбцов и плейсхолдерами
            $columns .= ', ' . $key;
            $placeholders .= ', :' . $key;
            $valuesForDisplay .= ", '" . $value . "'";
        }
        $i++;
    }

    // Проверяем, чтобы массив параметров не был пустым
    if (empty($columns) || empty($placeholders)) {
        echo "Не удалось сформировать SQL-запрос: параметры пустые.";
        return;
    }

    // Формируем SQL-запрос с использованием плейсхолдеров
    // Пример: INSERT INTO users (username, email) VALUES (:username, :email)
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

    // Формируем SQL-запрос с реальными значениями для отображения на экране
    // Пример: INSERT INTO users (username, email) VALUES ('JohnDoe', 'john@example.com')
    // $sqlForDisplay = "INSERT INTO $table ($columns) VALUES ($valuesForDisplay)";

    // Выводим SQL-запрос с реальными значениями для проверки
    // echo "Сформированный SQL-запрос (с данными): " . $sqlForDisplay . "<br>";

    // Подготавливаем SQL-запрос к выполнению
    $query = $pdo->prepare($sql);

    // Привязываем реальные значения к плейсхолдерам
    foreach ($params as $key => $value) {
        // Связываем плейсхолдер (например, :username) с реальным значением (например, 'JohnDoe')
        $query->bindValue(':' . $key, $value);
    }

    // Выполняем подготовленный запрос
    $query->execute();

    // Проверка на наличие ошибок выполнения запроса (реализация функции dbCheckError предполагается отдельно)
    dbCheckError($query);

    // Возврат id
    return $pdo->lastInsertId();
}

// Функция для обновления строки в таблице
function update($table, $id, $params) {
    global $pdo;  // Используем глобальную переменную для доступа к PDO объекту

    // Массив для хранения частей SQL-запроса, которые будут содержать ключи и плейсхолдеры
    $updates = [];
    
    // Проходим по каждому элементу массива $params (ключ => значение)
    foreach ($params as $key => $value) {
        // Формируем строку вида 'ключ = :ключ' и добавляем ее в массив
        $updates[] = "$key = :$key";
    }

    // Преобразуем массив в строку с разделением по запятым, например: 'username = :username, email = :email'
    $str = implode(', ', $updates);

    // Формируем SQL-запрос, где в качестве условий используем $str и идентификатор строки
    $sql = "UPDATE $table SET $str WHERE id = :id";

    // Выводим SQL-запрос для проверки
    // echo "Сформированный SQL-запрос: " . $sql . "<br>";

    // Подготавливаем SQL-запрос через PDO
    $query = $pdo->prepare($sql);

    // Привязываем значения параметров (значения массива $params) к соответствующим плейсхолдерам
    foreach ($params as $key => $value) {
        $query->bindValue(':' . $key, $value);  // Пример: ':username' => 'новое значение'
    }

    // Привязываем идентификатор строки (id) к плейсхолдеру ':id'
    $query->bindValue(':id', $id, PDO::PARAM_INT);  // Указываем, что $id - это целочисленное значение

    // Выполняем запрос
    $query->execute();

    // Проверяем наличие ошибок
    dbCheckError($query);  // Вызов функции для проверки ошибок выполнения запроса
}

// Функция удаления
function delete($table, $id) {
    global $pdo;
    $sql = "DELETE FROM $table WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

// Выборка записей (posts) с автором в админку
function selectAllFromPostsAWithAdmin($table1, $table2) {
    global $pdo; 
    $sql = "
    SELECT 
    t1.id,
    t1.title,
    t1.description,
    t1.img,
    t1.content,
    t1.status,
    t1.id_topic,
    t1.created_date,
    t2.username
    FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id";
    $query = $pdo->prepare($sql);
    $query-> execute();
    return $query->fetchAll();
}
// Выборка записей (posts) для статьи
function selectForArticle($table1, $table2) {
    global $pdo; 
    $sql = "
    SELECT 
    t1.id,
    t1.title,
    t1.description,
    t1.img,
    t1.content,
    t1.id_topic,
    t1.status,
    t1.created_date,
    t2.username
    FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id";
    $query = $pdo->prepare($sql);
    $query-> execute();
    return $query->fetchAll();
}