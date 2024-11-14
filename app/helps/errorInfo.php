<?php
if (count($errorMsg) > 0): ?>
<ul class="posts__error">
    <!-- Открывающий тег ul -->
    <?php foreach ($errorMsg as $error): ?>
    <?php if (is_array($error)): // Если $error — массив, распечатать его с помощью print_r ?>
    <li><?php echo print_r($error, true); ?></li>
    <?php else: // Если $error — строка, вывести её напрямую ?>
    <li><?php echo htmlspecialchars($error); ?></li>
    <?php endif; ?>
    <?php endforeach; ?>
</ul> <!-- Закрывающий тег ul -->
<?php endif; ?>