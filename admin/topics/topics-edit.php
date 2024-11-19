<?php
    session_start();
    include("../../pass.php"); 
    include("../../app/controllers/topics.php"); 
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Редактировать категорию</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- topics-edit -->
        <section class="topics-edit">

            <div class="topics-edit__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="topics-edit__content">

                    <div class="topics-edit__menu">

                        <a href="<?=BASE_URL . "admin/topics/topics-create.php";?>" class="topics-edit__menu-el">Создать
                            категорию</a>
                        <a href="<?=BASE_URL . "admin/topics/topics-index.php";?>"
                            class="topics-edit__menu-el">Редактировать категорию</a>

                    </div>

                    <!-- topics-edit__form -->
                    <form action="topics-edit.php" class="topics-edit__form" method="POST"
                        enctype="multipart/form-data">

                        <h2 class="topics-edit__form-heading">Редактировать категорию</h2>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <div class="topics-edit__form-box">
                            <input value="<?=$id?>" type="hidden" name="id" class="topics-edit__form-input"
                                id="topics-edit-id">
                        </div>

                        <div class="topics-edit__form-box">
                            <label class="topics-edit__form-label" for="topics-edit-title">Название категории</label>
                            <input value="<?=$name?>" name="name" class="topics-edit__form-input" type="text"
                                id="topics-edit-title">
                        </div>

                        <div class="topics-edit__form-box">
                            <label class="topics-edit__form-label" for="topics-edit-content">Содержание
                                категории</label>
                            <textarea name="description" class="topics-edit__form-textarea"
                                id="topics-edit-content"><?=$description?></textarea>
                        </div>

                        <button name="topic-edit" type="submit" class="topics-edit__form-submit">Редактировать
                            категорию</button>
                    </form>

                </div>

            </div>

        </section>


    </main>

    <script src="../../scripts/script.js"></script>
</body>

</html>