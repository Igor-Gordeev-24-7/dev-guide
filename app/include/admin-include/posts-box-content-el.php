<div class="posts__form-box">
    <label class="posts__form-label" for="posts-content">Содержание поста</label>
    <div class="posts__form-btns">
        <button id="add-subtitle" class="posts__form-btn" type="button">Подзаголовок</button>
        <button id="add-text" class="posts__form-btn" type="button">Текс</button>
        <button id="add-link" class="posts__form-btn" type="button">Ссылка</button>
        <button id="add-code" class="posts__form-btn" type="button">Код</button>
        <button id="add-img" class="posts__form-btn" type="button">Изображения</button>
        <button id="add-youtube" class="posts__form-btn" type="button">Видео youtube</button>
        <button id="add-rutube" class="posts__form-btn" type="button">Видео rutube</button>
        <button id="add-codepen" class="posts__form-btn" type="button">Codepen</button>

    </div>
    <textarea name="content" class="posts__form-textarea"
        id="posts-content"><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?><?php echo htmlspecialchars($content); ?></textarea>
</div>