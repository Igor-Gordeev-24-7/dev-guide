<?php 
session_start();
include("./pass.php"); 
include('./app/controllers/topics.php');
include('./app/controllers/posts.php');

// Определяем направление сортировки. По умолчанию сортируем от новых к старым
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

// Получаем ID темы из URL
$topicId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Получаем информацию о теме
$topic = selectOne('topics', ['id' => $topicId]);

// Получаем все посты
$posts = selectForArticle('posts', 'users');

// Фильтруем посты, связанные с текущей темой
$filteredPosts = array_filter($posts, function($post) use ($topicId) {
    return $post['id_topic'] == $topicId;
});

// Параметры для пагинации
$postsPerPage = 5; // Количество постов на странице
$totalPosts = count($filteredPosts);
$totalPages = ceil($totalPosts / $postsPerPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $totalPages)); // Убедимся, что страница в пределах допустимого диапазона

// Получаем посты для текущей страницы
$startIndex = ($page - 1) * $postsPerPage;
$sortedPosts = array_slice($filteredPosts, $startIndex, $postsPerPage);

// Сортируем статьи по дате в зависимости от выбранного направления сортировки
usort($sortedPosts, function($a, $b) use ($sortOrder) {
    $dateA = new DateTime($a['created_date']);
    $dateB = new DateTime($b['created_date']);
    return $sortOrder === 'desc' ? $dateB <=> $dateA : $dateA <=> $dateB;
});
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($topic['name']) ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="./styles/style.css" />
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
                        <h2 class="render-articles__heading">Публикации по теме: <?= htmlspecialchars($topic['name']) ?>
                        </h2>
                        <!-- Форма сортировки -->
                        <form method="GET" action="" class="render-articles__sort-form">
                            <input type="hidden" name="id" value="<?= $topic['id']; ?>">
                            <div class="render-articles__sort-wrapper">
                                <label class="render-articles__sort-label">Сортировка:</label>
                                <button type="submit" name="sort" value="asc"
                                    class="render-articles__sort-button <?= ($sortOrder === 'asc') ? 'active' : ''; ?>">
                                    Сначала старые
                                </button>
                                <button type="submit" name="sort" value="desc"
                                    class="render-articles__sort-button <?= ($sortOrder === 'desc') ? 'active' : ''; ?>">
                                    Сначала новые
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="render-articles__body">
                        <div class="render-articles__items">
                            <?php
                            $defaultImagePath = IMAGE_PATH . 'default.webp';
                            if (count($sortedPosts) > 0): 
                                foreach ($sortedPosts as $post): 
                                    if ($post['status'] == 1): 
                            ?>
                            <div class="render-articles__item">
                                <div class="render-articles__item-img-box">
                                    <?php
                                    $imageFilePath = IMAGES_DIR_PATH . $post['img'];
                                    $imagePath = IMAGE_PATH . htmlspecialchars($post['img']);
                                    if (!file_exists($imageFilePath) || empty($post['img'])) {
                                        $imagePath = $defaultImagePath;
                                    }
                                    ?>
                                    <img src="<?= $imagePath ?>" alt="item-img" class="render-articles__item-img" />
                                </div>

                                <div class="render-articles__item-content">
                                    <a href="article.php?id=<?=$post['id'];?>" class="render-articles__item-link">
                                        <h3 class="render-articles__item-heading">
                                            <?= htmlspecialchars($post['title']); ?>
                                        </h3>
                                    </a>

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
                                </div>
                            </div>
                            <?php 
                                    endif;
                                endforeach; 
                            else:
                            ?>
                            <p class="render-articles__no-articles">Статьи по данной теме не найдены.</p>
                            <?php endif; ?>
                        </div>

                        <!-- info-column -->
                        <?php include('./app/include/info-column.php'); ?>
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="render-articles__pagination render-articles__pagination-container">
                    <?php if ($page > 1): ?>
                    <a href="?id=<?= $topicId ?>&sort=<?= $sortOrder ?>&page=<?= $page - 1 ?>"
                        class="render-articles__prev">Предыдущая</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?id=<?= $topicId ?>&sort=<?= $sortOrder ?>&page=<?= $i ?>"
                        class="render-articles__link <?= ($page == $i) ? 'active' : ''; ?>">
                        <?= $i ?>
                    </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <a href="?id=<?= $topicId ?>&sort=<?= $sortOrder ?>&page=<?= $page + 1 ?>"
                        class="render-articles__next">Следующая</a>
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