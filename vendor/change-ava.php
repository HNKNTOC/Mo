<?php
require_once 'connect.php';

$id_user = $_SESSION['user']['id_user'];
$expl_name = explode('.', $_FILES['avatar']['name']);
$file_name = $id_user . 'ava' . time() . '.' . $expl_name[1];

$path = 'uploads/' . $file_name;

if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
    header('Location: ../profile.php');
}else{ 
    $file_path = mysqli_fetch_array(mysqli_query($connect, "SELECT `ava` FROM `users` WHERE `id_user`= '$id_user'"));
    $file_path = 'uploads/' . (string)$file_path['ava'];

    if ($_SESSION['user']['ava'] != 'default_ava.jpg'){
        unlink('../' . $file_path);
    }

    mysqli_query($connect, "UPDATE `users` SET `ava` = '$file_name' WHERE `id_user` = '$id_user'");
    $_SESSION['user']['ava'] = $file_name;
    header('Location: ../profile.php');
}

