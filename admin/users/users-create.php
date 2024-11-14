<?php 
session_start();
include(__DIR__ . '/../../pass.php');
include(ROOT_PATH . '/app/controllers/users.php');
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Добавление пользователя</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/admin-include/admin-header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- users-create -->
        <section class="users-create">

            <div class="users-create__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="users-create__content">

                    <div class="users-create__menu">
                        <a href="<?=BASE_URL . "admin/users/users-create.php";?>" class="users-create__menu-el">Создать
                            пользователя</a>
                        <a href="<?=BASE_URL . "admin/users/users-index.php";?>"
                            class="users-create__menu-el">Управление пользователями</a>
                    </div>

                    <form action="users-create.php" class="users-create__form" method="POST"
                        enctype="multipart/form-data">
                        <h2 class="users-create__form-heading">Создание пользователя</h2>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <!-- email -->
                        <label class="users-create__form-label" for="email">Email:</label>
                        <input disabled class="users-create__form-input" type="email" id="email" value="<?=$email?>"
                            name="email" />

                        <!-- username -->
                        <label class="users-create__form-label" for="username">Логин:</label>
                        <input class="users-create__form-input" type="text" id="username" value="<?=$username?>"
                            name="username" />

                        <!-- password -->
                        <label class="users-create__form-label" for="password">Пароль:</label>
                        <input class="users-create__form-input" type="password" id="password" name="password-first" />

                        <!-- повтор пароля -->
                        <label class="users-create__form-label" for="password-second">Повторите пароль:</label>
                        <input class="users-create__form-input" type="password" id="password-second"
                            name="password-second" />

                        <div class="users-create__form-box">
                            <label for="user-category">Роль</label>
                            <select id="user-category" name="category" class="users-create__form-select"
                                aria-label="Выберите категорию">
                                <option value="">Выберите роль</option>
                                <option value="news">User</option>
                                <option value="tutorial">Admin</option>
                            </select>
                        </div>

                        <!-- Кнопка -->
                        <button name="create-user" type="submit" class="users-create__form-submit">Добавить
                            пользователя</button>
                    </form>

                </div>

            </div>

        </section>


    </main>

    <script src="../../scripts/script.js"></script>
</body>

</html>