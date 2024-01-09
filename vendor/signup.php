<?php
require_once 'connect.php';

switch (date('m')) {
    case 1:
        $month_name = 'января';
        break;
    case 2:
        $month_name = 'февраля';
        break;
    case 3:
        $month_name = 'марта';
        break;  
    case 4:
        $month_name = 'апреля';
        break;
    case 5:
        $month_name = 'мая';
        break;
    case 6:
        $month_name = 'июня';
        break;
    case 7:
        $month_name = 'июля';
        break;
    case 8:
        $month_name = 'августа';
        break;
    case 9:
        $month_name = 'сентября';
        break;
    case 10:
        $month_name = 'октября';
        break;
    case 11:
        $month_name = 'ноября';
        break;
    case 12:
        $month_name = 'декабря';
        break;
    };

$date = date("d $month_name Y");

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $address = 'г Москва ';
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    $logcheck = mysqli_query($connect,"SELECT `login` FROM `users` WHERE `login` = '$login'");
    $emailcheck = mysqli_query($connect,"SELECT `email` FROM `users` WHERE `email` = '$email'");

    if (($login == '') or ($email == '') or ($password == '') or ($password_confirm == '') or ($name == '') or ($surname == '') or ($tel == '')) {
        $_SESSION['message'] = 'Не все поля заполнены';
        header('Location: ../register.php');
    }else{
        if (mysqli_num_rows($logcheck) > 0) {
            $_SESSION['message'] = 'Такой логин уже занят';
            header('Location: ../register.php');
        }else{
            if (mysqli_num_rows($emailcheck) > 0) {
                $_SESSION['message'] = 'Эта почта уже занята';
                header('Location: ../register.php');
            }else{
                if ($password_confirm === $password){
                
                    $password = md5($password);
            
                    mysqli_query($connect, "INSERT INTO `users` (`login`, `email`, `password`, `name`, `surname`, `date`, `address`, `telephone`) VALUES ('$login', '$email', '$password', '$name', '$surname', '$date', '$address', '$tel')");
            
                    $_SESSION['message'] = 'Регистрация прошла успешно!';
                    header('Location: ../login.php');
                } else {
                    $_SESSION['message'] = 'Пароли не совпадают';
                    header('Location: ../register.php');
                }
            }
        }
    }   
?>
