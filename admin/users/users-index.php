<?php 
session_start();
include("../../pass.php"); 
include('../../app/controllers/users.php'); 
?>

<!-- Стили прописаны style/admin-elements/admin-style/admin-style.sccs -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Пользователи</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- users-index -->
        <section class="users-index">

            <div class="users-index__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="users-index__content">

                    <div class="users-index__menu">

                        <a href="<?=BASE_URL . "admin/users/users-create.php";?>" class="users-index__menu-el">Создать
                            пользователя</a>
                        <a href="<?=BASE_URL . "admin/users/users-index.php";?>" class="users-index__menu-el">Управление
                            пользователями</a>
                    </div>

                    <div class="users-index__header">

                        <h2 class="users-index__header-title">Управление пользователями</h2>

                        <div class="users-index__header-container users-index__header-container--users">

                            <div class="users-index__header-el" id="user-id">ID</div>
                            <div class="users-index__header-el" id="user-username">Логин</div>
                            <div class="users-index__header-el" id="user-email">Email</div>
                            <div class="users-index__header-el" id="user-role">Роль</div>
                            <div class="users-index__header-el" id="user-edit">
                                <button class="users-index__header-el-btn" id="user-edit-btn">Edit</button>
                            </div>
                            <div class="users-index__header-el" id="user-delete">
                                <button class="users-index__header-el-btn" id="user-delete-btn">Delit</button>
                            </div>

                        </div>

                    </div>

                    <div class="users-index__items">

                        <?php foreach ($users as $key => $user): ?>

                        <div class="users-index__item">

                            <div class="users-index__item-container users-index__item-container--users">

                                <div class="users-index__item-el"><?=$user['id']?></div>
                                <div class="users-index__item-el"><?=$user['username']; ?></div>
                                <div class="users-index__item-el"><?=$user['email']; ?></div>
                                <div class="users-index__item-el">
                                    <?php if ($user['admin'] == 1): ?>
                                    Admin
                                    <?php else: ?>
                                    User
                                    <?php endif; ?>
                                </div>
                                <div class="users-index__item-el">
                                    <a href="users-edit.php?id=<?=$user['id']; ?>"
                                        class="users-index__item-el-link">edit</a>
                                </div>
                                <div class="users-index__item-el">
                                    <form action="users-edit.php" method="GET"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
                                        <input type="hidden" name="del_id"
                                            value="<?= htmlspecialchars($user['id']); ?>">
                                        <button type="submit" class="users-index__item-el-link">delite</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </section>


    </main>

    <script type="module" src="../../scripts/script.js"></script>
</body>

</html>