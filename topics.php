<?php 
session_start();
include("./pass.php"); 
include('./app/controllers/topics.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Категории</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="./styles/style.css" />
    <meta name="description"
        content="<?= htmlspecialchars($topic['description'] ?? 'Обсуждение на тему: ' . $topic['name']); ?>" />
    <meta name="keywords" content="<?= htmlspecialchars($topic['keywords'] ?? 'тема, обсуждение, статьи'); ?>" />
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
        <!-- topics -->
        <div class="topics">
            <div class="topics__wrapper wrapper">
                <div class="topics__container">

                    <h2 class="render-articles__heading">Категории:</h2>

                    <div class="topics__items">
                        <?php foreach ($topics as $topic): ?>
                        <a href="topic.php?id=<?= $topic['id']; ?>" class="topics__item">
                            <span class="topics__item-name"><?= $topic['name']; ?></span>
                            <span class="topics__item-description"><?= $topic['description']; ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script type="module" src="./scripts/script.js"></script>
</body>

</html>