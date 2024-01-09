<?php
require_once 'connect.php';

$id_ad = $_POST['id_ad'];
$images_query = mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad`= '$id_ad'");

while($row = mysqli_fetch_array($images_query)){
    if (!unlink('../'.$row['path'])){
        die('Ошибка при удалении фото объявления');
    }
};
if (!mysqli_query($connect, "DELETE FROM `ads` WHERE `id_ad` = '$id_ad'")){
    die('Ошибка при удалении объявления');
};