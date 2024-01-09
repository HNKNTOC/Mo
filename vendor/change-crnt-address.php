<?php
require_once 'connect.php';

$id_user = $_SESSION['user']['id_user'];
$address = $_POST['address'];

if (isset($_SESSION['user'])){
if (mysqli_query($connect, "UPDATE `users` SET `address` = '$address' WHERE `id_user` = '$id_user'")) {    
    $_SESSION['user']['address'] = $address;
    header('Location: ../index.php');
}
}else{
    $_SESSION['address'] = $address;
    header('Location: ../index.php');
}

