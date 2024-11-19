<?php 
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

                        <!-- Блок с добавлением разметки в textarea posts-popup-gallery-add-img-to-content-el -->
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
                                    <?= htmlspecialchars($topic['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
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

    <!-- Скрипт добавления разметки в поле content -->
    <script type="module" src="../../scripts/add-el-to-post-content.js"></script>
    <!-- Скрипт активации popup и добавления разметки изображения в поле content -->
    <script type="module" src="../../scripts/posts-popup-gallery-add-img-to-content.js"></script>

</body>

</html>