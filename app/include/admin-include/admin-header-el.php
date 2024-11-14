<!-- admin-header-el -->
<header class="header" id="header">
    <div class="header__wrapper wrapper">
        <a href="#" class="header__logo">/dev/guide/</a>
        <nav class="header__menu">
            <ul class="header__menu-items">
                <li class="header__menu-item">
                    <a href="<?php echo BASE_URL; ?>" class="header__menu-item-link">Главная</a>
                </li>
                <li class="header__menu-item">
                    <a href="<?php echo BASE_URL; ?>articles.php" class="header__menu-item-link">Статьи</a>
                </li>
                <li class="header__menu-item">
                    <a href="#" class="header__menu-item-link">Уроки</a>
                </li>
                <li class="header__menu-item">
                    <a href="#" class="header__menu-item-link">О проекте</a>
                </li>

                <?php if(isset($_SESSION['id'])): ?>

                <li class="header__menu-item submenu-open-el">

                    <a href="#" class="header__menu-item-link "> <?php echo $_SESSION['username']; ?></a>

                    <div class="header__menu-submenu submenu">

                        <a href="<?php echo BASE_URL; ?>logout.php" class="header__menu-submenu-link">Выход</a>

                    </div>

                </li>

                <?php endif; ?>

            </ul>
        </nav>
    </div>
</header>