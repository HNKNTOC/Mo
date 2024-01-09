<?php
require_once 'connect.php';

$id_user = $_SESSION['user']['id_user'];


$name = $_POST['name'];
$surname = $_POST['surname'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$curent_password = $_POST['curent_password'];
$new_password = $_POST['new_password'];
$password_confirm = $_POST['password_confirm'];

if ($name != '' && $surname != '') {
    if (mysqli_query($connect, "UPDATE `users` SET `name` = '$name', `surname` = '$surname' WHERE `id_user` = '$id_user'")) {
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['surname'] = $surname;
        header('Location: ../profile.php');
    }else{
        die('Ошибка при изменении имени и фамилии пользователя');
    }
}

if ($tel != '') {
    if (mysqli_query($connect, "UPDATE `users` SET `telephone` = '$tel' WHERE `id_user` = '$id_user'")) {
        $_SESSION['user']['telephone'] = $tel;
        header('Location: ../profile.php');
    }else{
        die('Ошибка при изменении номера телефона пользователя');
    }
}

if ($email != '') {
    $emailcheck = mysqli_query($connect,"SELECT `email` FROM `users` WHERE `email` = '$email'");
    
    if (mysqli_num_rows($emailcheck) > 0) {
        $_SESSION['message'] = 'Эта почта уже занята';
        header('Location: ../profile.php');
    }else{
        if (mysqli_query($connect, "UPDATE `users` SET `email` = '$email' WHERE `id_user` = '$id_user'")) {
            $_SESSION['user']['email'] = $email;
            header('Location: ../profile.php');
        }else{
            die('Ошибка при изменении email пользователя');
        }
    }   
}

if ($curent_password != '' && $new_password != '' && $password_confirm != '') {
    $curent_password_sql = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_user'"));
    if ((md5($curent_password) == $curent_password_sql['password']) && $new_password == $password_confirm) {
        $new_password = md5($new_password);
        if (mysqli_query($connect, "UPDATE `users` SET `password` = '$new_password' WHERE `id_user` = '$id_user'")) {
            header('Location: ../profile.php');
        }else{
            die('Ошибка при изменении пароля пользователя');
        }
    }
}