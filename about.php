<?php 
include("./pass.php");
include("./app/controllers/users.php"); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>О сайте</title>
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

        <!-- about -->
        <div class="about">
            <div class="about__wrapper wrapper">

                <div class="about__container">



                </div>

            </div>
        </div>

    </main>

    <!-- footer -->
    <?php include("./app/include/footer-el.php"); ?>

    <script src="./scripts/script.js"></script>
</body>

</html>