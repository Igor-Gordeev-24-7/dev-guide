<?php
session_start();
include("./pass.php");
include("./app/database/db.php");

$feedback = ''; // Переменная для хранения сообщения об ошибке или успехе

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
    $secret = '6Ld604UqAAAAADkWqHZS-paZ17_I-XUqcuSUM832'; // Ваш секретный ключ reCAPTCHA

    if (!empty($recaptchaToken)) {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret' => $secret,
            'response' => $recaptchaToken,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        // Отправляем запрос к API reCAPTCHA
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

        if ($result['success'] && $result['score'] > 0.5) {
            $fio = htmlspecialchars(trim($_POST['fio']));
            $email = htmlspecialchars(trim($_POST['email']));
            $message = htmlspecialchars(trim($_POST['message']));
            if (mail("dev-guide@yandex.ru", "Заявка с сайта", "ФИО: $fio. E-mail: $email. Сообщение: $message", "From: info@satename.ru \r\n")) {
                $feedback = "<p>Сообщение успешно отправлено!</p>";
            } else {
                $feedback = "<p>При отправке сообщения возникли ошибки.</p>";
            }
        } else {
            // $feedback = "<p>Проверка reCAPTCHA не пройдена. Попробуйте позже.</p>";
        }
    } else {
        $feedback = "<p>Ошибка проверки reCAPTCHA. Попробуйте еще раз.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>О сайте</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon.png" />
    <link rel="stylesheet" href="./styles/style.css" />
    <meta name="description"
        content="О сайте Dev-Guide: подробная информация о проекте, его целях и миссии. Свяжитесь с администрацией через удобную форму обратной связи.">
    <meta name="keywords"
        content="о сайте Dev-Guide, информация о проекте, связь с администрацией, контакты, веб-разработка, поддержка пользователей, Dev-Guide">
    <meta name="author" content="Dev-Guide Team">
    <script src="https://www.google.com/recaptcha/api.js?render=6Ld604UqAAAAAK2PvVQPV9Mb7yyb1vWwSIj6W1OQ"></script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function(m, e, t, r, i, k, a) {
        m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        for (var j = 0; j < document.scripts.length; j++) {
            if (document.scripts[j].src === r) {
                return;
            }
        }
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
            k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(99007405, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true
    });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/99007405" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body>
    <!-- header -->
    <?php include("./app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">
        <section class="about">
            <div class="about__wrapper wrapper">

                <h1 class="about__heading">О проекте</h1>

                <p class="about__text">
                    Суть проекта, сохранить полученные навыки программирования, разработки, и
                    поделиться со всеми кто столкнувшимися со схожими проблемами или проектами.
                </p>

                <div class="about__container">
                    <!-- Форма -->
                    <form action="about.php" method="post" class="about__form" id="contact-form">
                        <h2 class="about__form-heading">Связь с администрацией</h2>

                        <!-- Вывод сообщений -->
                        <?php if ($feedback): ?>
                        <div class="feedback">
                            <?= $feedback; ?>
                        </div>
                        <?php endif; ?>

                        <input class="about__input" placeholder="Ваше имя" type="text" name="fio" required>
                        <input class="about__input" placeholder="Ваш e-mail" type="email" name="email">
                        <textarea class="about__textarea" name="message" cols="50" rows="10"
                            placeholder="Ваше сообщение сюда..."></textarea>
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        <input class="about__input-submit" type="submit" value="Отправить">
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script type="module" src="./scripts/script.js"></script>

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