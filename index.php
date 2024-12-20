<?php
session_start();
// Подключаем файл конфигурации
include("./pass.php"); 

// Подключаем файл posts.php, используя константу SITE_ROOT
include(SITE_ROOT . '/app/controllers/posts.php');

// Определяем направление сортировки. По умолчанию сортируем от новых к старым
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

// Устанавливаем параметры пагинации
$postsPerPage = 5; // Количество постов на странице
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Текущая страница
$offset = ($page - 1) * $postsPerPage; // Смещение для SQL-запроса

// Получаем все посты (без фильтрации по темам)
$posts = selectForArticle('posts', 'users');

// Сортируем и фильтруем посты по статусу публикации
$sortedPosts = array_filter($posts, function($post) {
    return $post['status'] == 1; // Только опубликованные посты
});

// Сортировка постов по дате
usort($sortedPosts, function($a, $b) use ($sortOrder) {
    $dateA = new DateTime($a['created_date']);
    $dateB = new DateTime($b['created_date']);
    return $sortOrder === 'desc' ? $dateB <=> $dateA : $dateA <=> $dateB;
});

// Отбираем посты для текущей страницы
$paginatedPosts = array_slice($sortedPosts, $offset, $postsPerPage);
$totalPages = ceil(count($sortedPosts) / $postsPerPage); // Общее количество страниц
?>

<!-- Стили прописаны style/elements/render-articles -->

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Главная</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="./styles/style.css" />
    <meta name="description"
        content="Dev-Guide — ваш путеводитель в веб-разработке. Полезные скрипты, видеоуроки, курсы по HTML, CSS, JavaScript и другим технологиям. Учитесь, создавайте и развивайте свои навыки!">
    <meta name="keywords"
        content="веб-разработка, HTML, CSS, JavaScript, курсы программирования, видеоуроки, скрипты, программирование для начинающих, разработка сайтов, Dev-Guide, обучение программированию">
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
    <main class="main" id="main" role="main">
        <!-- render-articles -->
        <section class="render-articles" id="render-articles" aria-labelledby="render-articles-heading">
            <div class="render-articles__wrapper wrapper">
                <div class="render-articles__content">
                    <div class="render-articles__header">
                        <h2 class="render-articles__heading" id="render-articles-heading">Последние публикации</h2>

                        <!-- Форма сортировки -->
                        <?php include('./app/include/render-articles-sort-form-main-page.php'); ?>

                    </div>
                    <div class="render-articles__body">
                        <div class="render-articles__items" role="list">
                            <?php
                            $defaultImagePath = IMAGE_PATH . 'default.webp';
                            foreach ($paginatedPosts as $post):
                                // Путь к изображению для поста
                                $imageFilePath = IMAGES_DIR_PATH . $post['img'];
                                $imagePath = IMAGE_PATH . htmlspecialchars($post['img']);
                                if (!file_exists($imageFilePath) || empty($post['img'])) {
                                    $imagePath = $defaultImagePath;
                                }
                            ?>
                            <div class="render-articles__item" role="listitem">
                                <div class="render-articles__item-img-box">
                                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($post['title']); ?>"
                                        class="render-articles__item-img" />
                                </div>

                                <a href="article.php?id=<?= $post['id']; ?>" class="render-articles__item-content"
                                    aria-labelledby="post-<?= $post['id']; ?>"
                                    aria-label="Читать статью: <?= htmlspecialchars($post['title']); ?>">
                                    <h3 class="render-articles__item-heading" id="post-<?= $post['id']; ?>">
                                        <?php
                                        $title = htmlspecialchars($post['title']);
                                        if (strlen($title) > 100) {
                                            $title = substr($title, 0, 100) . '...';
                                        }
                                        echo $title;
                                        ?>
                                    </h3>

                                    <div class="render-articles__item-info">
                                        <span
                                            class="render-articles__item-author"><?= htmlspecialchars($post['username']); ?></span>
                                        <span class="render-articles__item-date">
                                            <?php 
                                            $date = new DateTime($post['created_date']);
                                            echo $date->format('d.m.Y');
                                            ?>
                                        </span>
                                    </div>
                                    <p class="render-articles__item-description">
                                        <?php
                                        $description = $post['description'];
                                        echo mb_strlen($description, 'UTF-8') > 150 ? mb_substr($description, 0, 150, 'UTF-8') . '...' : $description;
                                        ?>
                                    </p>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- info-column -->
                        <?php include('./app/include/info-column.php'); ?>
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="render-articles__pagination render-articles__pagination-container" role="navigation"
                    aria-label="Пагинация">
                    <?php if ($page > 1): ?>
                    <a href="?sort=<?= $sortOrder ?>&page=<?= $page - 1 ?>" class="render-articles__prev"
                        aria-label="Предыдущая страница">Предыдущая</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?sort=<?= $sortOrder ?>&page=<?= $i ?>"
                        class="render-articles__link <?= ($page == $i) ? 'active' : ''; ?>"
                        aria-label="Страница <?= $i ?>">
                        <?= $i ?>
                    </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <a href="?sort=<?= $sortOrder ?>&page=<?= $page + 1 ?>" class="render-articles__next"
                        aria-label="Следующая страница">Следующая</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script type="module" src="./scripts/script.js"></script>
</body>

</html>