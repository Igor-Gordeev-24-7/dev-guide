<form method="GET" action="" class="render-articles__sort-form">
    <input type="hidden" name="id" value="<?= $topicId ?>">

    <label class="render-articles__sort-label">Сортировка:</label>
    <div class="render-articles__sort-form-box">
        <button type="submit" name="sort" value="desc"
            class="render-articles__sort-button <?= $sortOrder === 'desc' ? 'active' : ''; ?>">
            Сначала новые
        </button>
        <button type="submit" name="sort" value="asc"
            class="render-articles__sort-button <?= $sortOrder === 'asc' ? 'active' : ''; ?>">
            Сначала старые
        </button>
    </div>
</form>