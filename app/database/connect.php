<?php
use Dotenv\Dotenv;

include __DIR__ . '/../../vendor/autoload.php';

// Указываем путь к директории, где находится файл .env
$dotenv = Dotenv::createImmutable('/var/www/u2789992/data/www/dev-guide.ru');
$dotenv->load();

// Получение переменных окружения
$driver = isset($_ENV['DB_DRIVER']) ? $_ENV['DB_DRIVER'] : 'mysql';
$host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : '127.0.0.1';
$db_name = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : 'default_db';
$db_user = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : 'root';
$db_pass = isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : '';
$charset = isset($_ENV['DB_CHARSET']) ? $_ENV['DB_CHARSET'] : 'utf8mb4';

// Настройка PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    // echo "Подключение успешно!";
} catch (PDOException $e) {
    // die("Ошибка подключения к базе данных: " . $e->getMessage());
}