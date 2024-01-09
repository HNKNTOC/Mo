<?php
require_once 'connect.php';

$id_user = $_POST['id_user'];

if (mysqli_query($connect, "UPDATE `users` SET `status` = 'banned' WHERE `id_user` = '$id_user'")) {
    $img_query = mysqli_query($connect, "SELECT * FROM `images` JOIN ads ON ads.id_ad = images.id_ad WHERE ads.id_user = '$id_user'");

    while ($row = mysqli_fetch_assoc($img_query)) {
        unlink('../'.$row['path']);
    }

    mysqli_query($connect, "DELETE FROM `ads` WHERE `id_user` = '$id_user'");

    $file_name = mysqli_fetch_array(mysqli_query($connect, "SELECT `ava` FROM `users` WHERE `id_user`= '$id_user'"));
    $file_path = 'uploads/' . (string)$file_name['ava'];

    if ((string)$file_name['ava'] != 'default_ava.jpg'){
        unlink('../' . $file_path);
    }

    mysqli_query($connect, "UPDATE `users` SET `ava` = 'banned_ava.jpg' WHERE `id_user` = '$id_user'");
}else{
    die('Ошибка при блокировке пользователя');
}

