<!-- Элемент добаляет на страницу popup блок, активация и функционал прописаны в файле  posts-popup-gallery-add-img-to-content.js -->

<?php 
// Подключаем PHP-файл, который отвечает за получение изображений
include("../../getImages.php"); 
?>

<!-- Основной контейнер для галереи изображений с классом posts__gallery и идентификатором posts-gallary -->
<div class="posts__gallery" id="posts-gallary">

    <!-- Кнопка закрытия галереи (крестик) -->
    <span class="posts__gallery-close" id="gallery-close">&times;</span>

    <!-- Список изображений внутри галереи с идентификатором popup-imgs -->
    <ul class="posts__gallery-items" id="popup-imgs">
        <?php 
        // Проверяем, если в результате выполнения getImages.php есть ошибка, выводим сообщение об ошибке
        if (isset($result['error'])) {
        ?>
        <li class="posts__gallery-item">
            Ошибка: <?php echo $result['error']; ?>
        </li>
        <?php
        } else {
            // Если ошибки нет, перебираем массив изображений и создаем элементы списка для каждого изображения
            foreach ($result as $image) {
        ?>
        <li class="posts__gallery-item">
            <!-- Изображение с использованием пути к файлу. Для безопасности выводим имя изображения через htmlspecialchars -->
            <img src="/assets/uploads/<?php echo htmlspecialchars($image); ?>"
                alt="<?php echo htmlspecialchars($image); ?>" class="posts__gallery-item-img">
            <!-- Подпись с именем файла изображения -->
            <span class="posts__gallery-item-span"><?php echo htmlspecialchars($image); ?></span>
        </li>
        <?php
            }
        }
        ?>
    </ul>
</div>