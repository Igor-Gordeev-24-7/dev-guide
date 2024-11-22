<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

// Инициализация Dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Теперь переменные окружения доступны через $_ENV или getenv()
$driver = $_ENV['DB_DRIVER'];
$host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$charset = $_ENV['DB_CHARSET'];

// Настройка PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    echo "Подключение успешно!";
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
