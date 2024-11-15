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
<script>
    grecaptcha.enterprise.ready(async () => {
        const token = await grecaptcha.enterprise.execute('6LfYz34qAAAAAMb8qBGVcCxr88z6-3S4QSaSSWUQ', {action: 'submit'});
        document.getElementById('agr-recaptcha-response').value = token;
    });
</script>