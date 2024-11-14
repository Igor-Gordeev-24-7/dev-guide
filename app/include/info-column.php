<!-- Боковая панель для поиска и навигации по категориям статей -->
<div class="info-column">
    <!-- Блок поиска -->
    <div class="info-column__search">
        <!-- Заголовок для поиска -->
        <span class="info-column__search-heading">Поиск</span>
        <!-- Форма поиска -->
        <form method="post" action="search.php" class="info-column__search-form">
            <!-- Поле ввода для поискового запроса -->
            <input placeholder="Введите искомое слово" type="text" class="info-column__search-input" name="search-term"
                required />
            <!-- Кнопка отправки формы -->
            <button type="submit" class="info-column__search-button">→</button>
        </form>
    </div>

    <!-- Блок категорий -->
    <div class="info-column__topics">
        <!-- Заголовок для списка категорий -->
        <h3 class="info-column__topics-heading">
            <a href="topics.php" class="info-column__topics-heading-link">Категории</a>
        </h3>
        <!-- Список категорий (топиков) -->
        <ul class="info-column__topics-items">
            <?php foreach ($topics as $key => $topic): ?>
            <li class="info-column__topics-item">
                <a href="topic.php?id=<?=$topic['id']; ?>"
                    class="info-column__topics-item-link"><?=$topic['name']; ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>