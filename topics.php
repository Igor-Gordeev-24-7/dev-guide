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