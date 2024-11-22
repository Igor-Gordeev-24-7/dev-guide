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
    <title>Все категории</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- posts -->
        <section class="topics-index">

            <div class="topics-index__wrapper wrapper">

                <!-- Подключение сайтбар -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="topics-index__content">

                    <div class="topics-index__menu">

                        <a href="<?=BASE_URL . "admin/topics/topics-create.php";?>"
                            class="topics-index__menu-el">Создать
                            категорию</a>
                        <a href="<?=BASE_URL . "admin/topics/topics-index.php";?>"
                            class="topics-index__menu-el">Редактировать
                            категорию</a>

                    </div>

                    <div class="topics-index__header">

                        <h2 class="topics-index__header-title">Управление категориями</h2>

                        <div class="topics-index__header-container topics-index__header-container--topics">

                            <div class="topics-index__header-el">ID</div>
                            <div class="topics-index__header-el">Название категории</div>
                            <div class="topics-index__header-el">
                                <button class="topics-index__header-el-btn">Edit</button>
                            </div>
                            <div class="topics-index__header-el">
                                <button class="topics-index__header-el-btn">Delite</button>
                            </div>

                        </div>

                    </div>

                    <div class="topics-index__items">

                        <?php foreach ($topics as $key => $topic): ?>
                        <div class="topics-index__item">

                            <div class="topics-index__item-container topics-index__item-container--topics">

                                <div class="topics-index__item-el"><?=$topic['id']?></div>
                                <div class="topics-index__item-el">
                                    <?php
                        if (mb_strlen($topic['name'], 'UTF-8') > 30) {
                            echo mb_substr($topic['name'], 0, 30, 'UTF-8') . '...';
                        } else {
                            echo $topic['name'];
                        }
                        ?>
                                </div>
                                <div class="topics-index__item-el">
                                    <a href="topics-edit.php?id=<?=$topic['id']; ?>"
                                        class="topics-index__item-el-link">edit</a>
                                </div>
                                <div class="topics-index__item-el">
                                    <form action="topics-index.php" method="POST"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить эту категорию?');">
                                        <input type="hidden" name="del_id"
                                            value="<?= htmlspecialchars($topic['id']); ?>">
                                        <button type="submit" class="topics-index__item-el-link">delite</button>
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