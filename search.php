<?php 
session_start();
include("./pass.php");
include("./app/database/db.php"); 
include("./app/controllers/posts.php");

// Проверка, был ли отправлен запрос на поиск
$searchTerm = isset($_POST['search-term']) ? trim($_POST['search-term']) : '';
$filteredPosts = [];

// Если поисковый термин задан, фильтруем посты
if ($searchTerm) {
    foreach ($postsAdmin as $post) {
        if ($post['status'] == 1 &&
            (stripos($post['title'], $searchTerm) !== false || 
             stripos($post['description'], $searchTerm) !== false)) {
            $filteredPosts[] = $post;
        }
    }
}

// Укажите путь к изображению-заглушке
$defaultImagePath = IMAGE_PATH . 'default.webp';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Поиск</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon.png" />
    <link rel="stylesheet" href="./styles/style.css" />
    <?php
    // Генерация мета-тега description на основе поискового запроса
    $description = "Результаты поиска";
    if ($searchTerm) {
        $description .= " для запроса «" . htmlspecialchars($searchTerm) . "»";
    }
    $description .= " на Dev-Guide: найдите статьи, скрипты и уроки по веб-разработке, которые вам нужны.";
    ?>
    <meta name="description" content="<?= $description; ?>">
    <meta name="keywords"
        content="поиск статей, поиск на Dev-Guide, веб-разработка, HTML, CSS, JavaScript, скрипты, уроки, курсы, программирование">
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
        <!-- render-articles -->
        <section class="render-articles" id="render-articles">
            <div class="render-articles__wrapper wrapper">
                <div class="render-articles__content">
                    <div class="render-articles__header">
                        <h2 class="render-articles__heading">Результаты поиска для:
                            "<?= htmlspecialchars($searchTerm); ?>"
                        </h2>
                    </div>

                    <div class="render-articles__body">
                        <div class="render-articles__items">
                            <?php if (!empty($filteredPosts)): ?>
                            <?php
                            $count = 0;
                            foreach ($filteredPosts as $post): 
                                if ($count >= 5) break; // Ограничиваем вывод до 5 постов

                                // Путь к изображению, указанному для поста
                                $imageFilePath = IMAGES_DIR_PATH . $post['img'];
                                // URL к изображению для отображения в браузере
                                $imagePath = (file_exists($imageFilePath) && !empty($post['img'])) 
                                    ? IMAGE_PATH . htmlspecialchars($post['img']) 
                                    : $defaultImagePath;
                        ?>
                            <div class="render-articles__item">
                                <div class="render-articles__item-img-box">
                                    <img src="<?= $imagePath; ?>" alt="item-img" class="render-articles__item-img" />
                                </div>

                                <a href="article.php?id=<?= $post['id']; ?>" class="render-articles__item-content">
                                    <h3 class="render-articles__item-heading">
                                        <?= htmlspecialchars($post['title']); ?>
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
                                        $description = htmlspecialchars($post['description']);
                                        echo (mb_strlen($description, 'UTF-8') > 150) 
                                            ? mb_substr($description, 0, 150, 'UTF-8') . '...' 
                                            : $description;
                                    ?>
                                    </p>
                                </a>
                            </div>
                            <?php 
                            $count++;
                            endforeach; 
                        ?>
                            <?php else: ?>
                            <p class="no-results-message">По вашему запросу ничего не найдено.</p>
                            <?php endif; ?>
                        </div>

                        <!-- info-column -->
                        <?php include('./app/include/info-column.php'); ?>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script type="module" src="./scripts/script.js"></script>

</body>

</html>