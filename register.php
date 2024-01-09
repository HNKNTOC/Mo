<?php 
    require('header.php');
?>

<section class="auth-cont">
    <form action="vendor/signup.php" method="post" enctype="multipart/form-data" class="auth-form">
        <div class="title">
            Регистрация
        </div>
        <input type="text" name="name" placeholder="Имя" required>
        <input type="text" name="surname" placeholder="Фамилия" required>
        <input type="text" name="tel" placeholder="Телефон" class="tel" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="login" placeholder="Логин" minlength="5" maxlength="30" required>
        <input type="password" name="password" placeholder="Пароль" minlength="8" maxlength="60" required>
        <input type="password" name="password_confirm" placeholder="Повторите пароль" minlength="8" maxlength="60" required>
        <input type="submit" class="auth-btn register-btn" value="Зарегестрироваться">
        <div>
            Уже зарегестрированы?
            <a href="login.php">
                Войти
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
    </form>
</section>

<?php
    require('footer.php')
?>