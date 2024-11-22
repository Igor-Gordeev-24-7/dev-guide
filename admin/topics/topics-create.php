<?php 
    include("../../pass.php"); 
    include("../../app/controllers/topics.php"); 
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Добавить категорию</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- posts -->
        <section class="topics-create">

            <div class="topics-create__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="topics-create__content">

                    <div class="topics-create__menu">

                        <a href="<?=BASE_URL . "admin/topics/topics-create.php";?>"
                            class="topics-create__menu-el">Создать категорию</a>
                        <a href="<?=BASE_URL . "admin/topics/topics-index.php";?>"
                            class="topics-create__menu-el">Редактировать категорию</a>

                    </div>

                    <!-- topics-create__form -->
                    <form action="topics-create.php" class="topics-create__form" method="POST"
                        enctype="multipart/form-data">

                        <h2 class="topics-create__form-heading">Создать категорию</h2>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <div class="topics-create__form-box">
                            <label class="topics-create__form-label" for="topics-create-title">Название
                                категории</label>
                            <input value="<?=$name?>" name="name" class="topics-create__form-input" type="text"
                                id="topics-create-title">
                        </div>

                        <div class="topics-create__form-box">
                            <label class="topics-create__form-label" for="topics-create-content">Содержание
                                категории</label>
                            <textarea name="description" class="topics-create__form-textarea"
                                id="topics-create-content"><?=$description?></textarea>
                        </div>

                        <div class="topics-edit__form-box">
                            <label class="topics-edit__form-label" for="topics-edit-content">Ключевые слова для
                                метатега</label>
                            <input name="keywords" class="topics-edit__form-input" type="text" id="topics-edit-title">
                        </div>

                        <button name="topic-create" type="submit" class="topics-create__form-submit">Создать
                            категорию</button>
                    </form>

                </div>

            </div>

        </section>

    </main>

    <script type="module" src="../../scripts/script.js"></script>
</body>

</html>