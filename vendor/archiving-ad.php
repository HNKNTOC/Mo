<?php
require_once 'connect.php';

$id_ad = $_POST['id_ad'];

mysqli_query($connect, "UPDATE `ads` SET `status` = 'archive' WHERE `id_ad` = '$id_ad'");