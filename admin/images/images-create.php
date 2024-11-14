<?php 
include("../../pass.php"); 
include("../../app/controllers/image.php"); 

?>

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

        <div class="admin-form">

            <div class="admin-form__wrapper wrapper">

                <!-- Подключение сайтбар -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="admin-form__content">

                    <form action="images-create.php" method="POST" class="admin-form__form"
                        enctype="multipart/form-data">

                        <h2 class="admin-form__form-heading">Добавление изображения</h2>

                        <!-- Вывод навигационного меню -->
                        <?php include("../../app/include/admin-include/images-menu-el.php"); ?>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <div class="admin-form__form-box">
                            <label class="admin-form__form-label" for="img-file">Загрузить изображение</label>
                            <input name="img" class="admin-form__form-input" type="file" id="img-file">
                        </div>

                        <div class="admin-form__form-box">
                            <button name="add-img" type="submit" class="admin-form__form-submit">Добавить
                                изображение</button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </main>

    <script type="module" src="../../scripts/script.js"></script>
</body>

</html>