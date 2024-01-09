<?php
require_once 'connect.php';

$id_user = $_POST['id_user'];
$id_role = $_POST['id_role'];

if (!mysqli_query($connect, "UPDATE `users` SET `role` = '$id_role' WHERE `id_user` = '$id_user'")) {
    die('Ошибка при изменении роли пользователя');
}

