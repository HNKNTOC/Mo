<?php
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
	$user = mysqli_fetch_assoc($check_user);

    if (mysqli_num_rows($check_user) > 0){
    	if ($user_arr['status'] != 'banned'){
          $_SESSION['user'] = [
              "id_user" => $user['id_user'],
              "name" => $user['name'],
              "surname" => $user['surname'],
              "login" => $user['login'],
              "email" => $user['email'],
              "ava" => $user['ava'],
              "address" => $user['address'],
              "telephone" => $user['telephone'],
              "role" => $user['role'],
          ];
          header('Location: ../index.php');
        }else{
        	$_SESSION['message'] = 'Аккаунт заблокирован';
        	header('Location: ../login.php');
        };
    }else{
        $_SESSION['message'] = 'Неверный логин или пароль';
        header('Location: ../login.php');
    }
