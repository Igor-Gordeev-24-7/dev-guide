<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Используем абсолютный путь для включения connect.php
if (file_exists(__DIR__ . '/connect.php')) {
    include(__DIR__ . '/connect.php');
} else {
    die('connect.php file not found');
}

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

if (!function_exists('test')) {
    function test($value){
        echo "<pre>";
        print_r($value); // выводим данные
        echo "</pre>";
    }
}

if (!function_exists('dbCheckError')) {
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
}

if (!function_exists('selectAll')) {
    function selectAll($table, $params = []) {
        // Делаем переменную $pdo доступной в функции
        global $pdo;

        // Формируем SQL-запрос для выбора всех данных из указанной таблицы
        $sql = "SELECT * FROM $table";

        // Проверяем, есть ли параметры для фильтрации
        if (!empty($params)) {
            $sql .= " WHERE ";
            $conditions = [];
            foreach ($params as $key => $value) {
                $conditions[] = "$key = :$key";
            }
            $sql .= implode(" AND ", $conditions);
        }

        // Подготавливаем запрос
        $query = $pdo->prepare($sql);

        // Привязываем параметры, если они есть
        foreach ($params as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        // Выполняем подготовленный запрос
        $query->execute();

        // Проверяем наличие ошибок
        dbCheckError($query);

        // Возвращаем все записи в виде ассоциативного массива
        return $query->fetchAll();
    }
}

if (!function_exists('selectOne')) {
    function selectOne($table, $params = []) {
        // Делаем переменную $pdo доступной в функции
        global $pdo;

        // Формируем SQL-запрос для выбора всех данных из указанной таблицы
        $sql = "SELECT * FROM $table";

        // Проверяем, есть ли параметры для фильтрации
        if (!empty($params)) {
            $sql .= " WHERE ";
            $conditions = [];
            foreach ($params as $key => $value) {
                $conditions[] = "$key = :$key";
            }
            $sql .= implode(" AND ", $conditions);
        }

        // Ограничиваем выборку до одной записи
        $sql .= " LIMIT 1";

        // Подготавливаем запрос
        $query = $pdo->prepare($sql);

        // Привязываем параметры, если они есть
        foreach ($params as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        // Выполняем подготовленный запрос
        $query->execute();

        // Проверяем наличие ошибок
        dbCheckError($query);

        // Возвращаем первую запись в виде ассоциативного массива
        return $query->fetch();
    }
}

if (!function_exists('insert')) {
    function insert($table, $params) {
        // Подключение глобальной переменной $pdo, представляющей подключение к базе данных
        global $pdo;

        // Переменные для формирования частей SQL-запроса
        $columns = '';        // Для имен столбцов
        $placeholders = '';   // Для плейсхолдеров значений (например, :username)
        $i = 0; // Счетчик для правильной расстановки запятых

        // Проходим по каждому элементу массива $params
        foreach ($params as $key => $value) {
            if ($i == 0) {
                // Для первого элемента не добавляем запятые
                $columns .= $key;  // Добавляем имя столбца (например, username)
                $placeholders .= ':' . $key;  // Добавляем плейсхолдер (например, :username)
            } else {
                // Для всех остальных элементов добавляем запятые перед именами столбцов и плейсхолдерами
                $columns .= ', ' . $key;
                $placeholders .= ', :' . $key;
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
}

if (!function_exists('update')) {
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
}

if (!function_exists('delete')) {
    function delete($table, $id) {
        global $pdo;
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        dbCheckError($stmt);
    }
}

if (!function_exists('selectAllFromPostsAWithAdmin')) {
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
        $query->execute();
        dbCheckError($query);
        return $query->fetchAll();
    }
}

if (!function_exists('selectForArticle')) {
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
        $query->execute();
        dbCheckError($query);
        return $query->fetchAll();
    }
}