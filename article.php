<?php 
session_start();
include("./pass.php");
include("./app/database/db.php");
include("./app/controllers/posts.php");

// Получение данных поста по его id
if ($_SERVER['REQUEST_METHOD'] === 'GET' ||$_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    // $id = $_GET['id'];

    $id = (int) $_GET['id'];

    // Получаем данные поста по id
    $postArticle = selectForArticle('posts', 'users', $id);
    $currentArticle = null;
    
    // Ищем пост с нужным id в массиве $postArticle
    foreach ($postArticle as $article) {
        if ($article['id'] == $id) {
            $currentArticle = $article;
            break;
        }
    }

    // Проверка на публикацию
    if ($currentArticle['status'] == 0) {
        header("Location: /index.php");
        exit();
    }

    // Проверка на существование поста
    if (!$currentArticle) {
        die("Пост не найден.");
    }

    // Извлечение данных для отображения
    $title = $currentArticle['title'];
    $description = $currentArticle['description'];
    $content = $currentArticle['content'];
    $topic = $currentArticle['id_topic'];
    $author = $currentArticle['username'];
    $date = $currentArticle['created_date'];
    $description = $currentArticle['description'];
    // Форматирование даты
    $dateFormatted = date("d.m.Y", strtotime($date));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon.png" />
    <link rel="stylesheet" href="./styles/style.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/atom-one-dark.min.css">
    <meta name="description"
        content="Читать статью на Dev-Guide: полезные материалы, советы и скрипты для веб-разработчиков. Изучайте лучшие практики и прокачивайте свои навыки!">
    <meta name="keywords"
        content="статья, веб-разработка, Dev-Guide, программирование, HTML, CSS, JavaScript, советы разработчикам, лучшие практики, полезные скрипты, курсы, уроки">
    <meta name="author" content="Dev-Guide Team">

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

        <img src="<?php ?>" alt="">

        <!-- article -->
        <section class="article">

            <div class="article__wrapper wrapper">

                <!-- article__container -->
                <div class="article__container">

                    <a href="../index.php" class="article__link-back">вернуться к статьям</a>

                    <div class="article__header">
                        <h2 class="article__heading"><?php echo htmlspecialchars($title); ?></h2>
                        <div class="article__header-info">
                            <span class="article__span-author">Автор: <?php echo htmlspecialchars($author); ?></span>
                            <span class="article__span-date">Дата публикации:
                                <?php echo htmlspecialchars($dateFormatted); ?></span>

                        </div>
                        <p class="article__description"><?php echo htmlspecialchars($description); ?></p>
                    </div>

                    <!-- article__body -->
                    <div class="article__body">

                        <!-- article__content -->
                        <div class="article__content">
                            <?php echo $content; ?>
                            <div id="popup" class="article__popup" style="display: none;">
                                <span class="article__popup-close popup-close" id="popupClose">&times;</span>
                                <img class="article__popup-img" id="popupImg" alt="Превью изображения" />
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script type="module" src="./scripts/script.js"></script>

    <script src="../../scripts/popup-image-preview.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js" defer></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        hljs.highlightAll();
    });
    </script>

</body>

</html>