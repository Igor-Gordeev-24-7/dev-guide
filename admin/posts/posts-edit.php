<?php
    session_start();
    include("../../pass.php"); 
    include("../../app/controllers/posts.php"); 
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Редактирование поста</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- posts-edit -->
        <section class="posts-edit">

            <div class="posts-edit__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="posts-edit__content">

                    <!-- posts-menu-el -->
                    <?php include("../../app/include/admin-include/posts-menu-el.php"); ?>

                    <!-- posts-edit__form -->
                    <form action="posts-create.php" class="posts-edit__form" method="POST"
                        enctype="multipart/form-data">

                        <h2 class="posts-edit__form-heading">Редактирование записи</h2>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <div class="posts-edit__form-box">
                            <label class="posts-edit__form-label" for="posts-title">Название статьи</label>
                            <input value="<?=$title?>" name="title" class="posts-edit__form-input" type="text"
                                id="posts-title">
                        </div>

                        <div class="posts-edit__form-box">
                            <label class="posts-edit__form-label" for="posts-title">Описание статьи</label>
                            <input value="<?=$description?>" name="description" class="posts-edit__form-input"
                                type="text" id="posts-title">
                        </div>

                        <div class="posts-edit__form-box">
                            <label class="posts-edit__form-label" for="posts-keywords">Ключевые слова для
                                метатега</label>
                            <input value="<?=$keywords?>" name="keywords" class="posts-edit__form-input" type="text"
                                id="posts-keywords">
                        </div>

                        <!-- Блок с добавлением разметки в textarea posts-box-content-el -->
                        <?php include('../../app/include/admin-include/posts-box-content-el.php'); ?>

                        <div id="popup" class="popup hidden">
                            <div class="popup__content">
                                <button id="popup-close" class="popup__close" type="button">×</button>
                                <h3 id="popup-title" class="popup__title"></h3>
                                <div id="popup-inputs" class="popup__inputs"></div>
                                <button id="popup-submit" class="popup__submit" type="button">Добавить</button>
                            </div>
                        </div>

                        <!-- Блок для работы с изображениями posts-edit-form-box-img -->
                        <?php include('../../app/include/admin-include/posts-form-box-img.php'); ?>

                        <!-- Скрытое поле для передачи текущего изображения -->
                        <input type="hidden" name="current_img" value="<?=$img?>">

                        <!-- posts-popup-gallery-add-img-to-content-el -->
                        <?php include('../../app/include/admin-include/posts-popup-gallery-add-img-to-content-el.php'); ?>

                        <!-- Скрытое поле для передачи ID поста -->
                        <input type="hidden" name="id" value="<?=$id?>">

                        <div class="posts-edit__form-box">
                            <label for="post-category">Категория</label>
                            <select name="topic" id="post-category" class="posts-edit__form-select"
                                aria-label="Выберите категорию">
                                <option selected disabled>Категория поста:</option>
                                <?php foreach ($topics as $key => $topic): ?>
                                <option value="<?=$topic['id']?>"
                                    <?=($topic['id'] == $post['id_topic']) ? 'selected' : '';?>>
                                    <?=$topic['name']?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="posts-edit__form-box posts-edit__form-box--checkbox">
                            <label for="post-publish">Publish</label>
                            <!-- Чекбокс для публикации -->
                            <input name="publish" class="posts-edit__form-input posts-edit__form-input--checkbox"
                                type="checkbox" value="1"
                                <?= isset($post['status']) && $post['status'] == 1 ? 'checked' : ''; ?>>
                        </div>

                        <button name="edit-post" type="submit" class="posts-edit__form-submit">Сохранить
                            изменения</button>
                    </form>

                </div>

            </div>

        </section>


    </main>


    <script type="module" src="../../scripts/script.js"></script>
    <!-- Подключение модуля JavaScript для работы с галереей изображений и добавления выбранного изображения в контент -->
    <script type="module" src="../../scripts/posts-popup-gallery-add-img-to-content.js"></script>
    <!-- Подключение модуля JavaScript для добавления элементов (например, заголовков, ссылок, кода) в контент поста -->
    <script type="module" src="../../scripts/add-el-to-post-content.js"></script>
    <!-- Подключение модуля JavaScript для реализации предпросмотра изображений в модальном окне -->
    <script type="module" src="../../scripts/popup-image-preview.js"></script>
</body>

</html>