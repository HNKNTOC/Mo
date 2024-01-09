<?php 
    require('header.php');
?>

<section class="auth-cont">
    <form action="vendor/signin.php" method="post" enctype="multipart/form-data" class="auth-form">
        <div class="title">
            Авторизация
        </div>
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="submit" class="auth-btn login-btn" value="Войти">
        <div>
            Ещё не зарегестрированы?
            <a href="register.php">
                Регистрация
            </a>
        </div>
        <p>
            <?php
            if (isset($_SESSION['message'])){
                echo $_SESSION['message'];
            }
            unset($_SESSION['message']);
            ?>
        </p>
    </div>
</section>

<?php
    require('footer.php')
?>