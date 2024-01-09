<?php
require_once('connect.php');

if (isset($_FILES['files'])) {
    $id_user = $_SESSION['user']['id_user'];
    $name = $_POST['name'];
    $id_category = $_POST['category'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    if ($price == '') {
        $price = 0;
    }

    //Запись даты и времени в БД типа "13 мая в 18:43"
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

    mysqli_query($connect, "INSERT INTO `ads` (`id_user`, `name`, `category`, `address`, `description`, `price`, `date`) VALUES ('$id_user', '$name', '$id_category', '$address', '$description', '$price', '$date')");


    $crnt_ad_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `ads` WHERE `id_user` = '$id_user' AND `name` = '$name'"));
    $id_ad = $crnt_ad_info['id_ad'];

    $file = $_FILES['files'];
    $fileCount = count($file["name"]);

    for ($i = 0; $i < $fileCount; $i++) {
        $file_type = explode('.', $file['name'][$i]);
        $file_name = $id_ad . 'ad_img' . $i . time() . '.' . $file_type[1];
        $path = 'uploads/' . $file_name;

        if (!move_uploaded_file($file['tmp_name'][$i], '../' . $path)){
            die('Ошибка при загрузке картинки');
        }else{
            mysqli_query($connect, "INSERT INTO `images` (`id_ad`, `path`) VALUES ('$id_ad', '$path')");
        }
    };

    header('Location: ../index.php');
}else{
    header('Location: ../ad.php');
}

