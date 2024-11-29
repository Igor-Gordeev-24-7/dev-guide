<?php
include(ROOT_PATH . '/pass.php');
?>
<!-- header -->
<header class="header" id="header">
    <div class="header__wrapper wrapper">
        <a href="<?php echo BASE_URL . 'index.php'; ?>" class="header__logo">/dev/guide/</a>

        <nav class="header__menu">

            <!-- Бургер-меню -->
            <div class="header__burger-menu" id="header__burger-menu">
                <span class="header__burger-icon"></span>
                <span class="header__burger-icon"></span>
                <span class="header__burger-icon"></span>
            </div>

            <ul class="header__menu-items" id="header__menu-items">
                <li class="header__menu-item">
                    <a href="<?php echo BASE_URL; ?>" class="header__menu-item-link">Главная</a>
                </li>
                <li class="header__menu-item">
                    <a href="<?php echo BASE_URL; ?>topics.php" class="header__menu-item-link">Категории</a>
                </li>

                <li class="header__menu-item">
                    <a href="<?php echo BASE_URL; ?>about.php" class="header__menu-item-link">О проекте</a>
                </li>
                <li class="header__menu-item submenu-open-el">
                    <?php if(isset($_SESSION['id'])): ?>
                    <a href="<?php echo BASE_URL . 'admin/posts/posts-index.php'; ?>" class="header__menu-item-link ">
                        <?php echo $_SESSION['username']; ?></a>

                    <div class="header__menu-submenu submenu">

                        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                        <a href="<?php echo BASE_URL . 'admin/posts/posts-index.php'; ?>"
                            class="header__menu-submenu-link">Админ панель</a>
                        <?php endif; ?>

                        <a href="<?php echo BASE_URL; ?>logout.php" class="header__menu-submenu-link">Выход</a>

                    </div>

                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
</header>