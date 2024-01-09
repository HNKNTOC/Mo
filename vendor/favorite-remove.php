<?php
require_once 'connect.php';

$id_user = $_POST['id_user'];
$id_ad = $_POST['id_ad'];

if (!mysqli_query($connect, "DELETE FROM `favorites` WHERE `id_user` = '$id_user' AND `id_ad` = '$id_ad'")){
    die('Ошибка при добавлении объявления в избранное');
}
