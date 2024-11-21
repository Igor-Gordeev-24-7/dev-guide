<?php 
include("./pass.php"); 
include("./app/controllers/users.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon.png" />
    <link rel="stylesheet" href="./styles/style.css" />
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfYz34qAAAAAMb8qBGVcCxr88z6-3S4QSaSSWUQ">
    </script>
</head>

<body>
    <!-- header -->
    <?php include("./app/include/header-el.php"); ?>

    <!-- main -->
    <main class="main">
        <!-- registration-el -->
        <section class="form form__registration">
            <div class="form__wrapper form-registration__wrapper wrapper">
                <form action="registration.php" method="POST" class="form__form form-registration__form"
                    id="registration-form">

                    <h3 class="form__heading form-registration__heading">Регистрация</h3>

                    <!-- Вывод массива с ошибками -->
                    <?php include(ROOT_PATH . '/app/helps/errorInfo.php');?>

                    <!-- email -->
                    <label class="form__label form-registration__label" for="email">Email:</label>
                    <input class="form__input form-registration__input" type="email" id="email" value="<?=$email?>"
                        name="email" required />

                    <!-- username -->
                    <label class="form__label form-registration__label" for="username">Логин:</label>
                    <input class="form__input form-registration__input" type="text" id="username" value="<?=$username?>"
                        name="username" required />

                    <!-- password -->
                    <label class="form__label form-registration__label" for="password-first">Пароль:</label>
                    <input class="form__input form-registration__input" type="password" id="password-first"
                        name="password-first" required />

                    <!-- password -->
                    <label class="form__label form-registration__label" for="password-second">Пароль:</label>
                    <input class="form__input form-registration__input" type="password" id="password-second"
                        name="password-second" required />

                    <div class="form__footer form-registration__footer">
                        <input type="hidden" name="g-recaptcha-response" id="agr-recaptcha-response" value="" />
                        <button type="submit" name="button-reg" class="form__submit form-registration__submit">
                            Зарегистрироваться
                        </button>
                        <a href="<?php echo BASE_URL; ?>login.php" class="form-registration__link">Войти</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script type="module" src="./scripts/script.js"></script>

    <script>
    grecaptcha.enterprise.ready(async () => {
        const token = await grecaptcha.enterprise.execute('6LfYz34qAAAAAMb8qBGVcCxr88z6-3S4QSaSSWUQ', {
            action: 'submit'
        });
        document.getElementById('agr-recaptcha-response').value = token;
    });
    </script>
</body>

</html>