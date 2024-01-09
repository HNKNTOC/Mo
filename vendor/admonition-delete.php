<?php
require_once 'connect.php';

$id_admonition = $_POST['id_admonition'];

if (!mysqli_query($connect, "DELETE FROM `admonition` WHERE `id_admonition` = '$id_admonition'")){
    die('Ошибка при удалении предупреждения');
}