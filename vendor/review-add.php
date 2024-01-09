<?php
require_once 'connect.php';

$id_trader = $_POST['id_trader'];
$id_user = $_POST['id_user'];
$text_rev = $_POST['text_rev'];  
$rating = $_POST['rating'];        

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

$date = date("d $month_name Y");

$reviewcheck = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_trader' AND `id_user` = '$id_user'");

if ((mysqli_num_rows($reviewcheck) < 1) && ($id_user != $id_trader) && ($rating != '')) {
    if (!mysqli_query($connect, "INSERT INTO `reviews` (`id_trader`, `id_user`, `text_rev`, `rating`, `date`) VALUES ('$id_trader', '$id_user', '$text_rev', '$rating', '$date' )")){
        die('Ошибка при добавлении отзыва');
    }
}
