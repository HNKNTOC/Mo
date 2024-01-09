<?php
require_once 'connect.php';

$id_user = $_POST['id_user'];

if (mysqli_query($connect, "UPDATE `users` SET `status` = 'active' WHERE `id_user` = '$id_user'")) {
    $img_query = mysqli_query($connect, "SELECT * FROM `images` JOIN ads ON ads.id_ad = images.id_ad WHERE ads.id_user = '$id_user'");

    mysqli_query($connect, "UPDATE `users` SET `ava` = 'default_ava.jpg' WHERE `id_user` = '$id_user'");
}else{
    die('Ошибка при разбане пользователя');
}

