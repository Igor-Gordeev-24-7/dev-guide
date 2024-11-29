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
    <title>Посты</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL . 'assets/icons/favicon.png' ?>" />
    <link rel="stylesheet" href="../../styles/style.css" />
</head>

<body>
    <!-- header -->
    <?php include("../../app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">

        <!-- posts-index -->
        <section class="posts-index">

            <div class="posts-index__wrapper wrapper">

                <!-- Подключение сайтбара -->
                <?php include("../../app/include/admin-include/admin-sidebar-el.php"); ?>

                <div class="posts-index__content">

                    <!-- posts-menu-el -->
                    <?php include("../../app/include/admin-include/posts-menu-el.php"); ?>

                    <div class="posts-index__header">

                        <h2 class="posts-index__header-title">Посты</h2>

                        <div class="posts-index__header-container posts-index__header-container--posts">

                            <div class="posts-index__header-el" id="post-id">ID</div>
                            <div class="posts-index__header-el" id="post-title">Название статьи</div>
                            <div class="posts-index__header-el" id="post-author">Автор</div>
                            <div class="posts-index__header-el" id="post-date">Дата</div>
                            <div class="posts-index__header-el" id="post-edit">
                                <button class="posts-index__header-el-btn" id="post-edit-btn">Edit</button>
                            </div>
                            <div class="posts-index__header-el" id="post-delete">
                                <button class="posts-index__header-el-btn" id="post-delete-btn">Delete</button>
                            </div>
                            <div class="posts-index__header-el" id="post-status">
                                <button class="posts-index__header-el-btn" id="post-status-btn">Status</button>
                            </div>
                            <div class="posts-index__header-el" id="post-status">Scheduled date</div>

                        </div>

                    </div>
                    <div class="posts-index__items">

                        <?php foreach ($postsAdmin as $key => $post): ?>

                        <div class="posts-index__item">
                            <div class="posts-index__item-container posts-index__item-container--posts">

                                <div class="posts-index__item-el"><?=$post['id'];?></div>
                                <div class="posts-index__item-el">
                                    <?php
                                $title = $post['title'];

                                if (mb_strlen($title, 'UTF-8') > 30) {
                                    echo mb_substr($title, 0, 30, 'UTF-8') . '...';
                                } else {
                                    echo $title;
                                }
                            ?>
                                </div>
                                <div class="posts-index__item-el">
                                    <?=$post['username'];?>
                                </div>
                                <div class="posts-index__item-el"><?=$post['created_date']; ?></div>

                                <div class="posts-index__item-el">
                                    <!-- Кнопка для редактирования -->
                                    <a href="posts-edit.php?id=<?=$post['id']; ?>"
                                        class="posts-index__item-el-link">edit</a>
                                </div>

                                <div class="posts-index__item-el">
                                    <!-- Форма для удаления -->
                                    <form action="posts-index.php" method="GET"
                                        onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?');">
                                        <input type="hidden" name="del_id"
                                            value="<?= htmlspecialchars($post['id']); ?>">
                                        <button type="submit" class="posts-index__item-el-link">delete</button>
                                    </form>
                                </div>

                                <div class="posts-index__item-el">
                                    <!-- Кнопка публикации -->
                                    <?php if ($post['status']): ?>
                                    <a href="posts-index.php?status=0&id=<?=$post['id']; ?>"
                                        class="posts-index__item-el-link">unpublish</a>
                                    <?php else: ?>
                                    <a href="posts-index.php?status=1&id=<?=$post['id']; ?>"
                                        class="posts-index__item-el-link">publish</a>
                                    <?php endif; ?>
                                </div>

                                <div class="posts-index__item-el">
                                    <!-- Отображение статуса публикации -->
                                    <?php if (isset($post['is_scheduled']) && $post['is_scheduled']): ?>
                                    <span>Запланировано на: <?=$post['scheduled_publish_date']; ?></span>
                                    <?php elseif (isset($post['status']) && $post['status'] == 1): ?>
                                    <span>Опубликовано</span>
                                    <?php else: ?>
                                    <span>Не запланировано</span>
                                    <?php endif; ?>
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