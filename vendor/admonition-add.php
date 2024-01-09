<?php
require_once('connect.php');

$id_user = $_POST['id_user'];
$text = $_POST['admonition_text'];
$id_author = $_SESSION['user']['id_user'];

mysqli_query($connect, "INSERT INTO `admonition` (`id_user`, `text`, `author`) VALUES ('$id_user', '$text', '$id_author')");


$admonition_num = mysqli_query($connect, "SELECT * FROM `admonition` WHERE `id_user` = '$id_user'");

if (mysqli_num_rows($admonition_num) == 3) {
    include('ban-user.php');
}


header('Location: ../profile__another-user.php?id_user='.$id_user);