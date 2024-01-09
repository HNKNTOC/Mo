<?php
    require('vendor/connect.php')
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tomla</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
</head>
<body>
   <!-- Шапка -->
   <header style="position: sticky;">
        <img src="img/easteregg.gif" class="disable">
        <a href="index.php" class="logo">
            Tomla
        </a>
        <!-- Окно выбора местоположения -->
        <div class="location-cont disable">
            <form class="location-window" action="vendor/change-crnt-address.php" method="post" enctype="multipart/form-data">
                <div class="title">
                    Выбор текущего местоположения
                </div>
                <input type="text" placeholder="Введите текущий адрес" name="address" class="address">
                    <label for="loc_sbmt">Отправить</label>
                <input type="submit" id="loc_sbmt" hidden>
                <div class="close">
                    <div class="close-line__1"></div>
                    <div class="close-line__2"></div>
                </div>
            </form>
        </div>
        <!-- Поиск объявлений -->
        <div class="search">
            <div class="search-inp-cont">
               <div class="location">
                    Местоположение: 
                    <div class="location-btn">
                        <?php
                        if (!isset($_SESSION['address'])) {
                            $_SESSION['address'] = 'г Москва';
                        }

                        if (!isset($_SESSION['user'])) {
                            if (strpos($_SESSION['address'], 'г ') === 0) {
                                $_SESSION['address'] = 'Слово' . $_SESSION['address'];
                            };
                            if (strpos($_SESSION['address'], 'г ')) {
                                $str = explode('г ', $_SESSION['address']);
                                $chr = 'г.';
                            };
                            if (strpos($_SESSION['address'], 'деревня ')) {
                                $str = explode('деревня ', $_SESSION['address']);
                                $chr = 'д.';
                            };
                            if (strpos($_SESSION['address'], 'село ')) {
                                $str = explode('село ', $_SESSION['address']);
                                $chr = 'с.';
                            };

                            $town = trim($str[1]);

                            $str = preg_split('/[\s,]+/', $str[1], -1, PREG_SPLIT_NO_EMPTY);
                            echo $chr . $str[0];
                        }else{
                            if (strpos($_SESSION['user']['address'], 'г ') === 0) {
                                $_SESSION['user']['address'] = 'Слово' . $_SESSION['user']['address'];
                            };
                            if (strpos($_SESSION['user']['address'], 'г ')) {
                                $str = explode('г ', $_SESSION['user']['address']);
                                $chr = 'г.';
                            };
                            if (strpos($_SESSION['user']['address'], 'деревня ')) {
                                $str = explode('деревня ', $_SESSION['user']['address']);
                                $chr = 'д.';
                            };
                            if (strpos($_SESSION['user']['address'], 'село ')) {
                                $str = explode('село ', $_SESSION['user']['address']);
                                $chr = 'с.';
                            };

                            $town = trim($str[1]);

                            $str = preg_split('/[\s,]+/', $str[1], -1, PREG_SPLIT_NO_EMPTY);
                            echo $chr . $str[0];
                        };

                        $_SESSION['town'] = $town;
                        ?>
                        <img src="img/pin.png">
                    </div>
                </div>
                <form class="search-input" action="search-page.php" method="get" enctype="multipart/form-data">
                    <input type="text" placeholder="Поиск по объявлениям" name="srch_str" 
                    <?
                        if (isset($_GET['srch_str'])) {
                            echo 'value="'.$_GET['srch_str'].'"';
                        }
                    ?>>
                    <input id="find" type="submit" value="Найти">
                    <input type="text" name="id_category" value="<?php echo $_GET['id_category']?>" hidden>
                    <input type="text" name="min_price" value="<?php echo $_GET['min_price']?>" hidden>
                    <input type="text" name="max_price" value="<?php echo $_GET['max_price']?>" hidden>
                </form> 
            </div>
            <div class="close-srch">
                <img src="img/favorite-plus.png" alt="">
            </div>
        </div>
        <div class="search-show-btn">
            <img src="img/search.png" alt="">
        </div>
        <?php
            if (isset($_SESSION['user'])){
                echo '
                    <input type="text" name="id_user" id="id_user_inHeader" hidden value="'.$_SESSION['user']['id_user'].'">
                    <div class="user">
                        <div class="menuToggle">
                            <div class="userBx">
                                <div class="user-ava">
                                    <img src="uploads/'; echo $_SESSION['user']['ava']; echo '">
                                </div>
                                <p class="user-name">';
                echo            $_SESSION['user']['name'];
                echo            ' ';
                echo            $_SESSION['user']['surname'];
                echo '          </p>
                            </div>
                            <div class="burger">
                                <div></div>
                            </div>
                        </div>
                        <ul class="menu">
                            <li><a href="new-ad.php"><img src="img/plus.png">Разместить объявление</a></li>
                            <li><a href="profile.php"><img src="img/account.png">Личный кабинет</a></li>
                            <li><a href="vendor/logout.php"><img src="img/logout.png">Выход</a></li>
                        </ul>
                    </div>
                ';
            }else{
                echo '
                    <a href="login.php" class="signin-btn">
                        Войти
                    </a>';
            }
        ?>
    </header>