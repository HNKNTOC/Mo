<?php
require_once 'connect.php';

$id_rev = $_POST['id_rev'];

if (!mysqli_query($connect, "DELETE FROM `reviews` WHERE `id_rev` = '$id_rev'")){
    die('Ошибка при удалении отзыва');
}