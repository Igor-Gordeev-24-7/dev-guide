<div class="posts__form-box">
    <!-- Лейбл для поля загрузки файла, который описывает его назначение для пользователей -->
    <label class="posts__form-label" for="file-upload">Загрузить файл</label>

    <!-- Поле для загрузки изображения, принимает файл и имеет атрибут name="img" -->
    <input name="img" type="file" id="file-upload" class="posts__form-input" aria-label="Загрузить файл">

    <!-- Выбор изображения из уже загруженных -->
    <label class="posts__form-label" for="existing-img">Выберите изображение из уже
        загруженных</label>
    <select name="existing_img" id="existing-img" class="posts__form-select" aria-label="Выберите изображение">
        <option value="">Выберите изображение</option>
        <?php
                // Получаем список всех изображений из директории
                $dir = "../../assets/uploads"; // Папка с изображениями
                $images = array_diff(scandir($dir), array('..', '.')); // Все файлы, кроме . и ..
                foreach ($images as $image): 
            ?>
        <option value="<?=$image?>" <?= ($image == $img) ? 'selected' : '' ?>>
            <?=$image?>
        </option>
        <?php endforeach; ?>
    </select>

    <?php if (!empty($img)): ?>
    <!-- Если переменная $img не пуста, отображаем текущее изображение -->
    <div class="posts__form-preview">
        <p class="posts__form-preview-text">Текущее изображение:</p>
        <img class="posts__form-preview-img preview-img" src="../../assets/uploads/<?= htmlspecialchars($img) ?>"
            alt="Превью изображения" style="max-width: 200px; height: auto;">
    </div>

    <!-- Модальное окно для предпросмотра изображения -->
    <div id="popup" class="posts__popup" style="display: none;">
        <span class="posts__popup-close popup-close" id="popupClose">&times;</span>
        <img class="posts__popup-img" id="popupImg" alt="Превью изображения" />
    </div>

    <?php endif; ?>
</div>