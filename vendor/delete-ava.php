<?php
require_once 'connect.php';

$id_user = $_SESSION['user']['id_user'];
$file_path = mysqli_fetch_array(mysqli_query($connect, "SELECT `ava` FROM `users` WHERE `id_user`= '$id_user'"));
$file_path = 'uploads/' . (string)$file_path['ava'];

if (($_SESSION['user']['ava'] != 'default_ava.jpg') && (unlink('../' . $file_path))){
    mysqli_query($connect, "UPDATE `users` SET `ava` = 'default_ava.jpg' WHERE `id_user` = '$id_user'");
    $_SESSION['user']['ava'] = 'default_ava.jpg';
}

header('Location: ../profile.php');