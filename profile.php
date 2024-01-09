<?php 
    if (!isset($_SESSION['user'])){
        header('Location: login.php');
    }
    
    require('header.php');
    $id_user = $_SESSION['user']['id_user'];
?>
<!-- Отзывы о пользователе -->
<div class="reviews disable">
    <div class="reviews-brightness">
        <div class="reviews-cont">
            <div class="reviews-scroll">
                <div class="title">
                    Отзывы о продавце
                </div>
                <div class="avg-rating__cont">
                    <div class="reviews__avg-rating">
                        <?php
                            $id_user = $_SESSION['user']['id_user'];

                            $rating_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_user'");

                            $rating = 0;
                            $count = 0;

                            while($row = mysqli_fetch_array($rating_query)){
                                $rating += $row['rating'];
                                $count++;
                            };
                            if ($count != 0){
                                $rating = $rating / $count;
                            }
                        ?>
                        <div><?php echo round($rating, 1); ?></div>
                        <div class="rating-result">
                            <span class="<?php if (ceil($rating) >= 1) echo 'active'; ?>"></span>	
                            <span class="<?php if (ceil($rating) >= 2) echo 'active'; ?>"></span>    
                            <span class="<?php if (ceil($rating) >= 3) echo 'active'; ?>"></span>  
                            <span class="<?php if (ceil($rating) >= 4) echo 'active'; ?>"></span>    
                            <span class="<?php if (ceil($rating) >= 5) echo 'active'; ?>"></span>
                        </div>
                    </div>
                </div>
                <?php
                    $reviews_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_user' ORDER BY `id_rev` DESC");
                    
                    while($row = mysqli_fetch_array($reviews_query)){
                        $id_author = $row['id_user'];
                        $author_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_author'"));
                        $rating = $row['rating'];

                        echo '
                        <div class="reviews-block">
                            <div class="reviews-block__user">
                                <div class="reviews-block__user-ava">
                                    <img src="uploads/'.$author_info['ava'].'">
                                </div>
                                <a href="profile__another-user.php?id_user='.$author_info['id_user'].'" class="reviews-block__user-name">'.
                                    $author_info['name'].' '.$author_info['surname'];?>
                                    <div class="rating-mini">
                                        <span class="<?php if ($rating >= 1) echo 'active'; ?>"></span>	
                                        <span class="<?php if ($rating >= 2) echo 'active'; ?>"></span>    
                                        <span class="<?php if ($rating >= 3) echo 'active'; ?>"></span>  
                                        <span class="<?php if ($rating >= 4) echo 'active'; ?>"></span>    
                                        <span class="<?php if ($rating >= 5) echo 'active'; ?>"></span>
                                    </div>
                <?php                            
                        echo    '</a>
                            </div>
                            <div>'.
                                $row['text_rev']
                            .'</div>
                            <div class="reviews-block__date">
                                <div>'.$row['date'].'</div>
                            </div>
                        </div>
                        ';
                    }
                    if (mysqli_num_rows($reviews_query) < 1) {?>
                        <div class="no-items">
                            <p>Отзывов нет &#9785;</p>
                        </div>
    <?php           }
                ?>
            </div>
            <div class="close">
                <div class="close-line__1"></div>
                <div class="close-line__2"></div>
            </div>
        </div>
        
    </div>
</div>

<div class="admonition disable">
    <?php
        $admonition_query = mysqli_query($connect, "SELECT * FROM `admonition` WHERE `id_user` = '$id_user'");
    ?>
    <div class="reviews-brightness">
        <div class="admonition-window">
            <div class="admonition-head">
                <div class="admonition-title">
                    Если вы получите 3 предупреждения, ваш аккаунт будет заблокирован
                </div>
            </div>
            <div class="admonition-items-cont">
                <?php
                    $num = 1;

                    while ($row = mysqli_fetch_array($admonition_query)) {
                ?>
                    <div class="admonition-block">
                        <div class="admonition-title">
                            Предупреждение <?php echo $num;?>
                        </div>
                        <div class="admonition-text">
                            <input type="text" value="<?php echo $row['id_admonition']?>" hidden>
                            <?php echo $row['text'];?>
                        </div>
                    </div>
                <?php
                    $num++;
                }
                ?>
            </div>
            
            <div class="close">
                <div class="close-line__1"></div>
                <div class="close-line__2"></div>
            </div>
        </div>
    </div>
</div>

<!-- Сообщение об ошибке -->
<div class="err__msg <?php if (!isset($_SESSION['message'])) {echo 'disable';} else {echo 'active';}?>">
    <p> 
        <?php
          if (isset($_SESSION['message'])){
            echo $_SESSION['message'];
          }
          unset($_SESSION['message']);
        ?>
    </p>
</div>

<section class="profile-cont">
    <!-- Меню личного кабинета -->
    <div class="profile-left">
        <div>
            <div class="profile-ava-cont">
                <div class="profile-ava">
                    <img src="uploads/<?php echo $_SESSION['user']['ava']; ?>">
                </div>
                <div class="profile-ava-change">
                    <img src="img/camera.png">
                </div>
                
                <!-- Окно смены аватарки -->
                <div class="profile-ava-change__dialog disable">
                    <form action="vendor/change-ava.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="avatar" id="ava-inp" accept="image/*" hidden onchange="this.form.submit();">
                        <label for="ava-inp">
                            <img src="img/image.png">
                            Загрузить
                        </label>
                    </form>
                    <form action="vendor/delete-ava.php" method="post" enctype="multipart/form-data">    
                        <input type="submit" id="ava-delete" hidden>
                        <label for="ava-delete">
                            <img src="img/delete.png">
                            Удалить
                        </label>
                    </form>
                </div>
            </div>
            <div class="profile-name">
                <?php
                    echo $_SESSION['user']['name'];
                    echo ' ';
                    echo $_SESSION['user']['surname']; 
                ?>
            </div>
            <div class="profile-rating">
                <?php
                    $rating_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_user'");

                    $rating = 0;
                    $count = 0;

                    while($row = mysqli_fetch_array($rating_query)){
                        $rating += $row['rating'];
                        $count++;
                    };
                    if ($count != 0){
                        $rating = $rating / $count;
                    }
                ?>     
                <div style="margin-right: 5px;"><?php echo round($rating, 1);?></div>
                <div class="rating-mini">
                            <span class="<?php if (ceil($rating) >= 1) echo 'active'; ?>"></span>	
                            <span class="<?php if (ceil($rating) >= 2) echo 'active'; ?>"></span>    
                            <span class="<?php if (ceil($rating) >= 3) echo 'active'; ?>"></span>  
                            <span class="<?php if (ceil($rating) >= 4) echo 'active'; ?>"></span>    
                            <span class="<?php if (ceil($rating) >= 5) echo 'active'; ?>"></span>
                        </div>
                <div class="usr-reviews" style="margin-left: 5px;"><?php echo $count?> отзыва</div>
            </div>
        </div>
        <div class="line"></div>
        <div class="profile-nav">
            <div class="profile-nav__1 nav-active">Мои объявления</div>
            <div class="profile-nav__2">Мои отзывы</div>
            <div class="profile-nav__3">Избранное</div>
            <div class="profile-nav__4">Настройки</div>
            <div class="admonition-btn">
                Предупрежедний: 
                <?php
                    echo mysqli_num_rows($admonition_query);
                ?>
            </div>
        </div>
    </div>
    <div class="profile-right">
        <!-- Мои объявления -->
        <div class="profile-item__cont">
            <div class="profile-item__nav">
                <div class="profile-item__nav-active selected">Активные</div>
                <div class="profile-item__nav-archive">Завершённые</div>
            </div>
            <!-- Активные -->
            <div class="profile-item__active">
                <?php
                $id_user = $_SESSION['user']['id_user'];
                $num_item = 1;
                
                $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `id_user` = '$id_user' AND `status` = 'active' ORDER BY `id_ad` DESC");

                while($row = mysqli_fetch_array($ads_query)){
                    if ($row['price'] == 0) {
                        $price = 'Бесплатно';
                    }else{
                        $price = $row['price'] . ' ₽';
                    }
                    
                    $id_ad = $row['id_ad'];
                    $img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = '$id_ad'"));

                    echo '
                    <div class="profile-item__block">
                        <div class="profile-item__img">
                            <img src="'. $img['path'] .'">
                        </div>
                        <div class="profile-item__info">
                            <a href="ad.php?id_ad='.$row['id_ad'].'" class="profile-item__title">'.
                                $row['name']
                            .'</a>
                            <div class="profile-item__price">'.
                                $price
                            .'</div>
                            <div class="profile-item__address">'.
                                $row['address']
                            .'</div>
                            <div class="profile_ad-actions">
                                <div class="profile_ad-actions_btn">
                                    <div class="profile_ad-actions_dots"></div>
                                </div>
                                <div class="profile_ad-actions_window disable">
                                    <div class="complete-ad">
                                        <div>Завершить</div>
                                    </div>
                                    <div class="delete-ad">
                                        <div>Удалить</div>
                                    </div>
                                    <input type="text" name="id_ad" value="'. $row['id_ad'] .'" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';

                    $num_item++;
                };
                if (mysqli_num_rows($ads_query) < 1) {?>
                    <div class="no-items">
                        <p>Объявлений нет &#9785;</p>
                    </div>
    <?php           }
                ?>
                
            </div>
            <!-- Завершённые -->
            <div class="profile-item__archive disable">
                <?php
                $id_user = $_SESSION['user']['id_user'];
                $num_item = 1;
                
                $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `id_user` = '$id_user' AND `status` = 'archive' ORDER BY `id_ad` DESC");

                while($row = mysqli_fetch_array($ads_query)){
                    if ($row['price'] == 0) {
                        $price = 'Бесплатно';
                    }else{
                        $price = $row['price'] . ' ₽';
                    }
                    
                    $id_ad = $row['id_ad'];
                    $img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = '$id_ad'"));

                    echo '
                    <div class="profile-item__block">
                        <div class="profile-item__img">
                            <img src="'. $img['path'] .'">
                        </div>
                        <div class="profile-item__info">
                            <a href="ad.php?id_ad='.$row['id_ad'].'" class="profile-item__title">'.
                                $row['name']
                            .'</a>
                            <div class="profile-item__price">'.
                                $price
                            .'</div>
                            <div class="profile-item__address">'.
                                $row['address']
                            .'</div>
                            <div class="profile_ad-actions">
                                <div class="profile_ad-actions_btn">
                                    <div class="profile_ad-actions_dots"></div>
                                </div>
                                <div class="profile_ad-actions_window disable">
                                    <div class="post-ad_btn">
                                        <div>Опубликовать</div>
                                    </div>
                                    <div class="delete-ad">
                                        <div>Удалить</div>
                                    </div>
                                    <input type="text" name="id_ad" value="'. $row['id_ad'] .'" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';

                    $num_item++;
                };
                if (mysqli_num_rows($ads_query) < 1) {?>
                    <div class="no-items">
                        <p>Объявлений нет &#9785;</p>
                    </div>
<?php           }
                ?>
            </div>
        </div>
        <!-- Мои отзывы -->
        <div class="profile-reviews__cont disable">
            <div class="title">
                Мои отзывы
            </div>
            <div class="profile-reviews">

            <?php
                    $id_user = $_SESSION['user']['id_user'];
                    
                    $reviews_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_user` = '$id_user' ORDER BY `id_rev` DESC");
                    
                    while($row = mysqli_fetch_array($reviews_query)){
                        $id_trader = $row['id_trader'];

                        $author_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_user'"));
                        $trader_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_trader'"));
                        $rating = $row['rating'];

                        echo '
                        <div class="profile-reviews__block">
                            <div>
                                <div class="lk-reviews-title__cont">
                                    <div class="user-ava">
                                        <img src="uploads/'.$author_info['ava'].'">
                                    </div>
                            ';?>

                                <div class="rating-result">
                                    <span class="<?php if ($rating >= 1) echo 'active'; ?>"></span>	
                                    <span class="<?php if ($rating >= 2) echo 'active'; ?>"></span>    
                                    <span class="<?php if ($rating >= 3) echo 'active'; ?>"></span>  
                                    <span class="<?php if ($rating >= 4) echo 'active'; ?>"></span>    
                                    <span class="<?php if ($rating >= 5) echo 'active'; ?>"></span>
                                </div>
                <?php       echo '
                                </div>
                                <div>'.
                                    $row['text_rev']
                                .'</div>
                                <div class="profile-reviews__info">
                                    <div>'.$row['date'].'</div>
                                    <a href="profile__another-user.php?id_user='.$row['id_trader'].'">'.$trader_info['name'].' '.$trader_info['surname'].'</a>
                                </div>
                            </div>
                            <input type="text" value="'.$row['id_rev'].'" hidden>
                            <div class="profile-reviews__delete">
                                <img src="img/delete.png">
                            </div>
                        </div>
                        ';
                    };
                    if (mysqli_num_rows($reviews_query) < 1) {?>
                        <div class="no-items">
                            <p>Отзывов нет &#9785;</p>
                        </div>
    <?php           }
                ?>
            </div>
        </div>
        <!-- Избранное -->
        <div class="profile-favorite__cont disable">
            <div class="title">
                Избранное
            </div>
            <div>
            <?php
                $id_user = $_SESSION['user']['id_user'];

                $ads_query = mysqli_query($connect, "SELECT * FROM `ads` JOIN `favorites` ON ads.id_ad = favorites.id_ad WHERE favorites.id_user = '$id_user'");

                
                while($row = mysqli_fetch_array($ads_query)){    
                    $id_ad = $row['id_ad'];
                    $img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = '$id_ad' LIMIT 1"));

                    if ($row['price'] == 0) {
                        $price = 'Бесплатно';
                    }else{
                        $price = $row['price'] . ' ₽';
                    }
                    
                    echo '
                    <div class="profile-item__block">
                        <div class="profile-item__img">
                            <img src="'. $img['path'] .'">
                        </div>
                        <div class="profile-item__info">
                            <a href="ad.php?id_ad='. $id_ad .'" class="profile-item__title">'.
                                $row['name'].
                            '</a>
                            <div class="profile-item__price">'.
                                $price
                            .'</div> 
                            <div class="profile-item__address">'.
                                $row['address']
                            .'</div> 
                            <input type="text" value="'. $id_ad .'" hidden>
                            <div class="favorites-remove" title="Удалить из избранного">
                                <img src="img/delete.png">
                            </div>
                        </div>
                    </div>
                    ';
                    };
                    if (mysqli_num_rows($ads_query) < 1) {?>
                        <div class="no-items">
                            <p>Объявлений нет &#9785;</p>
                        </div>
    <?php           }
            ?>
            </div>
        </div>
        <!-- Настройки -->
        <div class="profile-settings__cont disable">
            <?php 
                $id_user = $_SESSION['user']['id_user'];

                $user_info = mysqli_query($connect, "SELECT * FROM `ads` WHERE `price` = '0' AND `status` = 'active' ORDER BY `id_ad` DESC");
            ?>
            <div class="title">
                Настройки
            </div>
            <div class="profile-settings">
                <div class="profile-settings__login">
                    <div>Ваш логин:</div>
                    <div>
                        <?php
                            echo $_SESSION['user']['login'];
                        ?>
                    </div>
                </div>
                <form action="vendor/change-user-info.php" method="post" enctype="multipart/form-data">
                    <p>Имя и фамилия</p>
                    <input type="text" name="name" placeholder="Имя" required value="<?php echo $_SESSION['user']['name']?>">
                    <input type="text" name="surname" placeholder="Фамилия" required value="<?php echo $_SESSION['user']['surname']?>">
                    <input type="submit" value="Сохранить">
                </form>
                <form action="vendor/change-user-info.php" method="post" enctype="multipart/form-data">
                    <p>Номер телефона</p>
                    <input type="text" name="tel" placeholder="Телефон" class="tel" required value="<?php echo $_SESSION['user']['telephone']?>">
                    <input type="submit" value="Сохранить">
                </form>
                <form action="vendor/change-user-info.php" method="post" enctype="multipart/form-data">
                    <p>E-mail</p>
                    <input type="email" name="email" placeholder="E-mail" required value="<?php echo $_SESSION['user']['email']?>">
                    <input type="submit" value="Сохранить">
                    <p> 
                        <?php
                        if (isset($_SESSION['message'])){
                            echo $_SESSION['message'];
                        }
                        unset($_SESSION['message']);
                        ?>
                    </p>
                </form>
                <form action="vendor/change-user-info.php" method="post" enctype="multipart/form-data">
                    <p>Пароль</p>
                    <input type="password" name="curent_password" placeholder="Текущий пароль" required>
                    <input class="pass pass1" type="password" name="new_password" placeholder="Новый пароль" required>
                    <input class="pass pass2" type="password" name="password_confirm" placeholder="Повторите пароль" required>
                    <input class="submit" type="submit" value="Сохранить" disabled>
                </form>
            </div>
        </div>
    </div>
</section>
<?php 
    require('footer.php');
?>