<?php 
session_start();
include("../../app/helps/auth_check.php"); 
include(__DIR__ . '/../../pass.php');
include(ROOT_PATH . '/app/controllers/users.php');
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Редактирование пользователя</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- users-edit -->
        <section class="users-edit">

            <div class="users-edit__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="users-edit__content">

                    <div class="users-edit__menu">

                        <a href="<?=BASE_URL . "admin/users/users-create.php";?>" class="users-edit__menu-el">Создать
                            пользователя</a>
                        <a href="<?=BASE_URL . "admin/users/users-index.php";?>" class="users-edit__menu-el">Управление
                            пользователями</a>
                    </div>

                    <form action="users-edit.php?id=<?=$user['id']?>" class="users-edit__form" method="POST"
                        enctype="multipart/form-data">
                        <h2 class="users-edit__form-heading">Редактирование пользователя</h2>

                        <!-- Вывод массива с ошибками -->
                        <?php include("../../app/helps/errorInfo.php"); ?>

                        <!-- email -->
                        <label class="users-edit__form-label" for="email">Email:</label>
                        <input class="users-edit__form-input" type="email" id="email" value="<?=$email?>"
                            name="email" />

                        <!-- username -->
                        <label class="users-edit__form-label" for="username">Логин:</label>
                        <input class="users-edit__form-input" type="text" id="username" value="<?=$username?>"
                            name="username" />

                        <!-- password -->
                        <label class="users-edit__form-label" for="password">Пароль:</label>
                        <input class="users-edit__form-input" type="password" id="password" name="password-first"
                            placeholder="Оставьте пустым, если не хотите менять пароль" />

                        <!-- Роль -->
                        <div class="users-edit__form-box">
                            <label for="user-category">Роль</label>
                            <select id="user-category" name="category" class="users-edit__form-select">
                                <option value="0" <?= $admin == 0 ? 'selected' : '' ?>>User</option>
                                <option value="1" <?= $admin == 1 ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>

                        <!-- Кнопка -->
                        <button name="edit-user" type="submit" class="users-edit__form-submit">Обновить
                            пользователя</button>
                    </form>

                </div>

            </div>

        </section>


    </main>

    <script type="module" src="../../scripts/script.js"></script>
</body>

</html>