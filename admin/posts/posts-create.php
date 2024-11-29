<?php 
include("../../app/helps/auth_check.php"); 
include("../../pass.php"); 
include("../../app/controllers/posts.php"); 
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Создание поста</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- posts-create -->
        <section class="posts-create">

            <div class="posts-create__wrapper wrapper">

                <!-- Подключение сайтбар -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="posts-create__content">

                    <!-- posts-menu-el -->
                    <?php include("../../app/include/admin-include/posts-menu-el.php"); ?>

                    <!-- posts-create__form -->
                    <form action="posts-create.php" class="posts-create__form" method="POST"
                        enctype="multipart/form-data">

                        <h2 class="posts-create__form-heading">Добавление записи</h2>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <div class="posts-create__form-box">
                            <label class="posts-create__form-label" for="posts-title">Название статьи</label>
                            <input name="title" class="posts-create__form-input" type="text" id="posts-title"
                                value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
                        </div>

                        <div class="posts-create__form-box">
                            <label class="posts-create__form-label" for="posts-description">Описание статьи</label>
                            <input name="description" class="posts-create__form-input" type="text"
                                id="posts-description"
                                value="<?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?>">
                        </div>

                        <div class="posts-edit__form-box">
                            <label class="posts-edit__form-label" for="posts-keywords">Ключевые слова для
                                метатега</label>
                            <input name="keywords" class="posts-edit__form-input" type="text" id="posts-keywords">
                        </div>

                        <div id="popup" class="popup hidden">
                            <div class="popup__content">
                                <button id="popup-close" class="popup__close" type="button">×</button>
                                <h3 id="popup-title" class="popup__title"></h3>
                                <div id="popup-inputs" class="popup__inputs"></div>
                                <button id="popup-submit" class="popup__submit" type="button">Добавить</button>
                            </div>
                        </div>

                        <!-- Блок с добавлением разметки в textarea posts-box-content-el -->
                        <?php include('../../app/include/admin-include/posts-box-content-el.php'); ?>

                        <!-- Блок для работы с изображениями posts-create-form-box-img -->
                        <?php include('../../app/include/admin-include/posts-form-box-img.php'); ?>

                        <!-- posts-popup-gallery-el -->
                        <?php include('../../app/include/admin-include/posts-popup-gallery-add-img-to-content-el.php'); ?>

                        <div class="posts-create__form-box">
                            <label for="post-category">Категория</label>
                            <select name="topic" id="post-category" class="posts-create__form-select"
                                aria-label="Выберите категорию">
                                <option value="">Категория поста:</option>
                                <?php foreach ($topics as $key => $topic): ?>
                                <option value="<?= $topic['id'] ?>"
                                    <?= (isset($_POST['topic']) && $_POST['topic'] == $topic['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(string: $topic['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="scheduled_publish_date">Запланировать публикацию:</label>
                            <div class="input-group">
                                <input class="posts__scheduled-date" type="datetime-local" id="scheduled_publish_date"
                                    name="scheduled_publish_date" value="<?= $post['scheduled_publish_date'] ?? '' ?>">
                                <button type="button" class="posts__scheduled-date-reset btn btn-secondary"
                                    id="reset-scheduled-date">Сбросить</button>
                            </div>
                        </div>

                        <div class="posts-create__form-box posts-create__form-box--checkbox">
                            <label for="post-publish">Publish</label>
                            <input name="publish" class="posts-create__form-input posts-create__form-input--checkbox"
                                type="checkbox" value="1" id="post-publish"
                                <?= (isset($_POST['publish']) && $_POST['publish'] == '1') ? 'checked' : '' ?>>
                        </div>

                        <button name="add-post" type="submit" class="posts-create__form-submit">Добавить запись</button>

                    </form>

                </div>

            </div>

        </section>


    </main>

    <script type="module" src="../../scripts/script.js"></script>
    <!-- Скрипт добавления разметки в поле content -->
    <script type="module" src="../../scripts/add-el-to-post-content.js"></script>
    <!-- Скрипт активации popup и добавления разметки изображения в поле content -->
    <script type="module" src="../../scripts/posts-popup-gallery-add-img-to-content.js"></script>
    <!-- Скрипт отчистки поля даты -->
    <script>
    document.getElementById('reset-scheduled-date').addEventListener('click', function() {
        document.getElementById('scheduled_publish_date').value = '';
    });
    </script>
</body>

</html>