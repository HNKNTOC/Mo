<?php
require_once 'connect.php';

$id_ad = $_POST['id_ad'];

switch (date('m')) {
    case 1:
        $month_name = 'Января';
        break;
    case 2:
        $month_name = 'Февраля';
        break;
    case 3:
        $month_name = 'Марта';
        break;  
    case 4:
        $month_name = 'Апреля';
        break;
    case 5:
        $month_name = 'Мая';
        break;
    case 6:
        $month_name = 'Июня';
        break;
    case 7:
        $month_name = 'Июля';
        break;
    case 8:
        $month_name = 'Августа';
        break;
    case 9:
        $month_name = 'Сентября';
        break;
    case 10:
        $month_name = 'Октября';
        break;
    case 11:
        $month_name = 'Ноября';
        break;
    case 12:
        $month_name = 'Декабря';
        break;
    };

$date = date("d $month_name в H:i");

mysqli_query($connect, "UPDATE `ads` SET `status` = 'active', `date` = '$date' WHERE `id_ad` = '$id_ad'");