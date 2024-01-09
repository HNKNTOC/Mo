<?php
require_once 'connect.php';

$id_user = $_POST['id_user'];
$id_ad = $_POST['id_ad'];

if (!mysqli_query($connect, "INSERT INTO `favorites` (`id_user`, `id_ad`) VALUES ('$id_user', '$id_ad')")){
    die('Ошибка при добавлении объявления в избранное');
}
