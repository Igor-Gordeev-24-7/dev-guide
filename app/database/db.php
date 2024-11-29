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
        global $pdo;

        $sql = "SELECT * FROM $table";

        if (!empty($params)) {
            $sql .= " WHERE ";
            $conditions = [];
            $bindParams = [];

            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    // Обработка массива
                    $operator = $value[0];
                    $val = $value[1];
                    $conditions[] = "$key $operator :$key";
                    $bindParams[":$key"] = $val;
                } else {
                    $conditions[] = "$key = :$key";
                    $bindParams[":$key"] = $value;
                }
            }

            $sql .= implode(" AND ", $conditions);
        }

        $query = $pdo->prepare($sql);

        if (!empty($bindParams)) {
            foreach ($bindParams as $key => $value) {
                $query->bindValue($key, $value);
            }
        }

        $query->execute();
        dbCheckError($query);

        return $query->fetchAll();
    }
}

if (!function_exists('selectOne')) {
    function selectOne($table, $params = []) {
        global $pdo;

        $sql = "SELECT * FROM $table";

        if (!empty($params)) {
            $sql .= " WHERE ";
            $conditions = [];
            $bindParams = [];

            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    // Обработка массива
                    $operator = $value[0];
                    $val = $value[1];
                    $conditions[] = "$key $operator :$key";
                    $bindParams[":$key"] = $val;
                } else {
                    $conditions[] = "$key = :$key";
                    $bindParams[":$key"] = $value;
                }
            }

            $sql .= implode(" AND ", $conditions);
        }

        $sql .= " LIMIT 1";

        $query = $pdo->prepare($sql);

        if (!empty($bindParams)) {
            foreach ($bindParams as $key => $value) {
                $query->bindValue($key, $value);
            }
        }

        $query->execute();
        dbCheckError($query);

        return $query->fetch();
    }
}

if (!function_exists('insert')) {
    function insert($table, $params) {
        global $pdo;

        $columns = '';
        $placeholders = '';
        $i = 0;

        foreach ($params as $key => $value) {
            if ($i == 0) {
                $columns .= $key;
                $placeholders .= ':' . $key;
            } else {
                $columns .= ', ' . $key;
                $placeholders .= ', :' . $key;
            }
            $i++;
        }

        if (empty($columns) || empty($placeholders)) {
            echo "Не удалось сформировать SQL-запрос: параметры пустые.";
            return;
        }

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $query = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $query->bindValue(':' . $key, $value);
        }

        $query->execute();
        dbCheckError($query);

        return $pdo->lastInsertId();
    }
}

if (!function_exists('update')) {
    function update($table, $id, $params) {
        global $pdo;

        $updates = [];
        foreach ($params as $key => $value) {
            $updates[] = "$key = :$key";
        }

        $str = implode(', ', $updates);
        $sql = "UPDATE $table SET $str WHERE id = :id";

        $query = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $query->bindValue(':' . $key, $value);
        }

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        dbCheckError($query);
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
        t1.scheduled_publish_date,
        t1.is_scheduled,
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