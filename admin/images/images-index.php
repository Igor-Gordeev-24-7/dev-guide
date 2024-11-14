<?php 
include("../../pass.php"); 
include("../../app/controllers/image.php"); 

// Проверка и определение константы IMAGE_PATH, если она еще не определена
if (!defined('IMAGE_PATH')) {
    define('IMAGE_PATH', BASE_URL . 'assets/uploads/');
}

// Путь к папке с изображениями
$directory = '../../assets/uploads/';

// Получаем список файлов в папке с изображениями, если папка существует
$images = is_dir($directory) ? scandir($directory) : [];

?>

<!-- Стили происаны в файле style/admin-elements/images-index/images-index.scss -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Изображения</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/admin-include/admin-header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- images-index -->
        <section class="images-index">

            <div class="images-index__wrapper wrapper">

                <!-- Подключение сайтбар -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="images-index__content">

                    <h2 class="images-index__title">Изображения</h2>

                    <!-- Вывод массива с ошибками -->
                    <?php include("../../app/helps/errorInfo.php"); ?>

                    <!-- Вывод навигационного меню -->
                    <?php include("../../app/include/admin-include/images-menu-el.php"); ?>

                    <!-- Вывод массива с ошибками -->
                    <?php include("../../app/helps/errorInfo.php"); ?>

                    <div class="images-index__items">
                        <?php foreach ($images as $image): ?>
                        <?php if ($image !== '.' && $image !== '..'): ?>
                        <div class="images-index__item">
                            <img src="<?= IMAGE_PATH . $image ?>" class="images-index__img" alt="Image">
                            <span class="images-index__item-name"><?= htmlspecialchars($image) ?></span>

                            <!-- Кнопка удаления -->
                            <form action="images-index.php" method="POST" class="images-index__delete-form"
                                onsubmit="return confirm('Вы уверены, что хотите удалить это изображение?');">
                                <input class="images-index__delete-form-input" type="hidden" name="image"
                                    value="<?= htmlspecialchars($image) ?>">
                                <button type="submit" class="images-index__delete-btn">Удалить</button>
                            </form>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>

        </section>

    </main>

    <script type="module" src="../../scripts/script.js"></script>
</body>

</html>