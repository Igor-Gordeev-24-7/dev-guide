<?php 
include("../../pass.php"); 
?>

<!-- Стили прописаны файле style/ -->

<!-- admin__sidebar -->
<div class="sidebar">

    <ul class="sidebar__items">

        <li class="sidebar__item">
            <a href="<?=BASE_URL . "admin/posts/posts-index.php";?>" class="sidebar__item-link">Записи</a>
        </li>
        <li class="sidebar__item">
            <a href="<?=BASE_URL . "admin/topics/topics-index.php";?>" class="sidebar__item-link">Категории</a>
        </li>
        <li class="sidebar__item">
            <a href="<?=BASE_URL . "admin/images/images-index.php";?>" class="sidebar__item-link">Изображения</a>
        </li>
        <li class="sidebar__item">
            <a href="<?=BASE_URL . "admin/users/users-index.php";?>" class="sidebar__item-link">Пользователи</a>
        </li>

    </ul>

</div>