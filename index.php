<?php 
session_start();
include("./pass.php"); 
include('./app/controllers/posts.php');

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
                        <h2 class="render-articles__heading">Последние публикации</h2>

                        <!-- Форма сортировки -->
                        <form method="GET" action="" class="render-articles__sort-form">
                            <label class="render-articles__sort-label">Сортировка:</label>
                            <button type="submit" name="sort" value="desc"
                                class="render-articles__sort-button <?= $sortOrder === 'desc' ? 'active' : ''; ?>">
                                Сначала новые
                            </button>
                            <button type="submit" name="sort" value="asc"
                                class="render-articles__sort-button <?= $sortOrder === 'asc' ? 'active' : ''; ?>">
                                Сначала старые
                            </button>
                        </form>
                    </div>
                    <div class="render-articles__body">
                        <div class="render-articles__items">
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
                            <div class="render-articles__item">
                                <div class="render-articles__item-img-box">
                                    <img src="<?= $imagePath ?>" alt="item-img" class="render-articles__item-img" />
                                </div>

                                <div class="render-articles__item-content">
                                    <a href="article.php?id=<?=$post['id'];?>" class="render-articles__item-link">
                                        <h3 class="render-articles__item-heading">
                                            <?= htmlspecialchars($post['title']); ?></h3>
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
                            <?php endforeach; ?>
                        </div>
                        <!-- info-column -->
                        <?php include('./app/include/info-column.php'); ?>
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="render-articles__pagination render-articles__pagination-container">
                    <?php if ($page > 1): ?>
                    <a href="?sort=<?= $sortOrder ?>&page=<?= $page - 1 ?>" class="render-articles__prev">Предыдущая</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?sort=<?= $sortOrder ?>&page=<?= $i ?>"
                        class="render-articles__link <?= ($page == $i) ? 'active' : ''; ?>">
                        <?= $i ?>
                    </a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <a href="?sort=<?= $sortOrder ?>&page=<?= $page + 1 ?>" class="render-articles__next">Следующая</a>
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