<?php
session_start();
include("./pass.php");
include("./app/database/db.php");

// Установка времени начала работы формы
if (!isset($_SESSION['form_start_time'])) {
    $_SESSION['form_start_time'] = time();
}

$feedback = ''; // Сообщение об ошибке или успехе

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot
    if (!empty($_POST['honeypot'])) {
        die('Обнаружен спам-бот!');
    }

    // Ограничение по времени заполнения
    if (time() - $_SESSION['form_start_time'] < 3) {
        die('Форма заполнена слишком быстро. Пожалуйста, попробуйте снова.');
    }

    // Ограничение числа запросов с одного IP
    $ip = $_SERVER['REMOTE_ADDR'];
    $limit = 5; // Максимум 5 запросов
    $timeout = 3600; // 1 час
    if (!isset($_SESSION['requests'][$ip])) {
        $_SESSION['requests'][$ip] = ['count' => 1, 'start' => time()];
    } else {
        $_SESSION['requests'][$ip]['count']++;
        if ($_SESSION['requests'][$ip]['count'] > $limit && (time() - $_SESSION['requests'][$ip]['start'] < $timeout)) {
            die('Вы превысили лимит запросов. Попробуйте позже.');
        }
        if (time() - $_SESSION['requests'][$ip]['start'] > $timeout) {
            $_SESSION['requests'][$ip] = ['count' => 1, 'start' => time()];
        }
    }

    // reCAPTCHA
    $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
    $secret = '6Ld604UqAAAAADkWqHZS-paZ17_I-XUqcuSUM832'; // Ваш секретный ключ reCAPTCHA
    if (!empty($recaptchaToken)) {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret' => $secret,
            'response' => $recaptchaToken,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);

        if (!$result['success'] || $result['score'] <= 0.5) {
            die('Проверка reCAPTCHA не пройдена. Попробуйте позже.');
        }
    } else {
        die('Ошибка проверки reCAPTCHA. Попробуйте еще раз.');
    }

    // Валидация данных
    $fio = htmlspecialchars(trim($_POST['fio']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Некорректный email.');
    }
    if (!preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $fio)) {
        die('Имя должно содержать только буквы и пробелы.');
    }

    // Отправка письма
    if (mail("dev-guide@yandex.ru", "Заявка с сайта", "ФИО: $fio. E-mail: $email. Сообщение: $message", "From: info@satename.ru \r\n")) {
        $feedback = "<p>Сообщение успешно отправлено!</p>";
    } else {
        $feedback = "<p>При отправке сообщения возникли ошибки.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О сайте</title>
</head>

<body>
    <form action="about.php" method="post" id="contact-form">
        <h2>Связь с администрацией</h2>

        <!-- Вывод сообщений -->
        <?php if ($feedback): ?>
        <div class="feedback">
            <?= $feedback; ?>
        </div>
        <?php endif; ?>

        <input type="text" name="fio" placeholder="Ваше имя" required>
        <input type="email" name="email" placeholder="Ваш e-mail">
        <textarea name="message" cols="50" rows="10" placeholder="Ваше сообщение..."></textarea>

        <!-- Honeypot -->
        <input type="text" name="honeypot" style="display:none">

        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
        <input type="submit" value="Отправить">
    </form>

    <script src="https://www.google.com/recaptcha/api.js?render='6Ld604UqAAAAAK2PvVQPV9Mb7yyb1vWwSIj6W1OQ'"></script>
    <script>
    document.getElementById('contact-form').addEventListener('submit', function(event) {
        event.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('6Ld604UqAAAAAK2PvVQPV9Mb7yyb1vWwSIj6W1OQ', {
                action: 'submit'
            }).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
                event.target.submit();
            });
        });
    });
    </script>
</body>

</html>