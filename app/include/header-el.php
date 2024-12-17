<header class="header" id="header" role="banner">
    <div class="header__wrapper wrapper">
        <a href="<?php echo BASE_URL . 'index.php'; ?>" class="header__logo"
            aria-label="Главная страница">/dev/guide/</a>

        <nav class="header__menu" role="navigation">

            <!-- Бургер-меню -->
            <div class="header__burger-menu" id="header__burger-menu" aria-label="Открыть меню">
                <span class="header__burger-icon"></span>
                <span class="header__burger-icon"></span>
                <span class="header__burger-icon"></span>
            </div>

            <ul class="header__menu-items" id="header__menu-items" role="menu">
                <li class="header__menu-item" role="menuitem">
                    <a href="<?php echo BASE_URL; ?>" class="header__menu-item-link" aria-label="Главная">Главная</a>
                </li>
                <li class="header__menu-item" role="menuitem">
                    <a href="<?php echo BASE_URL; ?>topics.php" class="header__menu-item-link"
                        aria-label="Категории">Категории</a>
                </li>

                <li class="header__menu-item" role="menuitem">
                    <a href="<?php echo BASE_URL; ?>about.php" class="header__menu-item-link" aria-label="О проекте">О
                        проекте</a>
                </li>
                <li class="header__menu-item submenu-open-el" role="menuitem">
                    <?php if(isset($_SESSION['id'])): ?>
                    <a href="<?php echo BASE_URL . 'admin/posts/posts-index.php'; ?>" class="header__menu-item-link "
                        aria-label="Профиль пользователя <?php echo $_SESSION['username']; ?>">
                        <?php echo $_SESSION['username']; ?></a>

                    <div class="header__menu-submenu submenu" role="menu">

                        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                        <a href="<?php echo BASE_URL . 'admin/posts/posts-index.php'; ?>"
                            class="header__menu-submenu-link" aria-label="Админ панель">Админ панель</a>
                        <?php endif; ?>

                        <a href="<?php echo BASE_URL; ?>logout.php" class="header__menu-submenu-link"
                            aria-label="Выход">Выход</a>

                    </div>

                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
</header>