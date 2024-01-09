<?php
    session_start();
    
    $connect = mysqli_connect('localhost', 'root', '', 'mo');

    if (!$connect){
        die('Error connect to DataBase');
    }

    date_default_timezone_set('Europe/Samara');