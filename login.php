<?php 
include("./pass.php");
include("./app/controllers/users.php"); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Авторизация</title>
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

        <!-- form form-login -->
        <section class="form form__login">
            <div class="form__wrapper form-login__wrapper wrapper">
                <form action="login.php" method="POST" class="form__form form-login__form">
                    <h3 class="form__heading form-login__heading">Вход</h3>

                    <!-- Вывод массива с ошибками -->
                    <?php include(ROOT_PATH . '/app/helps/errorInfo.php');?>

                    <!-- email -->
                    <label class="form__lable form-login__lable" for="username">Почта:</label>
                    <input class="form__input form-registration__input" type="email" id="email" value="<?=$email?>"
                        name="email" />

                    <!-- password -->
                    <label class="form__lable form-login__lable" for="password">Пароль:</label>
                    <input class="form__input form-registration__input" type="password" id="password" name="password" />

                    <div class="form__footer form-login__footer">
                        <input type="hidden" name="g-recaptcha-response" id="agr-recaptcha-response" value="" />
                        <button type="submit" name="button-login" class="form__submit form-login__submit">Войти</button>
                        <a href="/registration.php" class="login__link">Зарегистрироваться</a>
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