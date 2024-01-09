<?php 
    require('header.php');

    $id_trader = $_GET['id_user'];

    $trader_query = mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = $id_trader");

    $trader_info = mysqli_fetch_array($trader_query);

    if ($_SESSION['user']['id_user'] == $id_trader){
        header('Location: profile.php');
    }
?>
<!-- Отзывы -->
<div class="review-add__cont disable">
    <div class="reviews-brightness">
        <div class="review-add">
            <div>
                <input type="text" id="id_trader" name="id_trader" value="<?php echo $id_trader?>" hidden>
                <p>Оставте свой отзыв</p>
                <div class="rating-area">
                    <input class="rating" type="radio" id="star-5" name="rating" value="5">
                    <label for="star-5" title="Оценка «5»"></label>	
                    <input class="rating" type="radio" id="star-4" name="rating" value="4">
                    <label for="star-4" title="Оценка «4»"></label>    
                    <input class="rating" type="radio" id="star-3" name="rating" value="3">
                    <label for="star-3" title="Оценка «3»"></label>  
                    <input class="rating" type="radio" id="star-2" name="rating" value="2">
                    <label for="star-2" title="Оценка «2»"></label>    
                    <input class="rating" type="radio" id="star-1" name="rating" value="1">
                    <label for="star-1" title="Оценка «1»"></label>
                </div>
                <textarea id="text_rev" name="text_rev" maxlength="2000" name="description" placeholder="Текст отзыва"></textarea>
                <div class="review-add__submit">
                    Отправить
                </div>
            </div>
            <div class="close">
                <div class="close-line__1"></div>
                <div class="close-line__2"></div>
            </div>
        </div>
    </div>
</div>

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

                            $rating_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_trader'");
                            $reviewcheck = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_trader' AND `id_user` = $id_user");

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
                    <?php
                        if (isset($_SESSION['user']) && ($id_trader != $_SESSION['user']['id_user']) && (mysqli_num_rows($reviewcheck) < 1)){
                            echo '
                                <div class="review-add__btn">
                                    Оставить отзыв
                                </div>
                            ';
                        };
                    ?>
                </div>
                <?php
                    $reviews_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_trader' ORDER BY `id_rev` DESC");
                    
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
        $admonition_query = mysqli_query($connect, "SELECT * FROM `admonition` WHERE `id_user` = '$id_trader'");
    ?>
    <div class="reviews-brightness">
        <div class="admonition-window">
            <div class="admonition-head">
                <div class="admonition-title">
                    Если вы получите 3 предупреждения, ваш аккаунт будет заблокирован
                </div>
                <?php
                    if (mysqli_num_rows($admonition_query) < 3) {
                ?>
                <form action="vendor/admonition-add.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="id_user" value="<?php echo $id_trader?>" hidden>
                    <textarea name="admonition_text"></textarea>
                    <input class="admonition-add-btn" type="submit" value="Добавить">
                </form>
                <?php
                    }
                ?>
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
                            <div class="delete-admonition">
                                <img src="img/no.png">
                            </div>
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
<section class="profile-cont">
    <!-- Информация о пользователе -->
    <div class="profile-left">
        <div>
            <div class="profile-ava">
                <img src="uploads/<?php echo $trader_info['ava']; ?>">
            </div>
            <div class="profile-name">
                <?php echo $trader_info['name'].' '.$trader_info['surname']; ?>
            </div>
            <div class="profile-rating">
                <?php
                    $rating_query = mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_trader'");

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
        <div class="another-user__info">
            На сайте с <?php echo $trader_info['date']; ?>
        </div>
        <?php if ($_SESSION['user']['role'] == 2 || $_SESSION['user']['role'] == 3) {
            ?>
        <div class="admonition-btn">
            Предупрежедний: 
            <?php
                echo mysqli_num_rows($admonition_query);
            ?>
        </div>
        <div class="admin-actions">
            <input type="text" value="<?php echo $trader_info['id_user'];?>" hidden>
            <?php
                if ($trader_info['status'] == 'active') {
                    ?>
                    <div class="ban-user">
                        Забанить пользователя
                    </div>
                    <?php
                }else {
                    ?>
                    <div class="unban-user">
                        Разбанить пользователя
                    </div>
                    <?php
                }
            ?>
            <?php if ($_SESSION['user']['role'] == 3) {
            ?>
            Изменить роль
            <select class="change-user-role">
                <?php
                    $categories_query = mysqli_query($connect, "SELECT * FROM `roles`");
    
                    while($row = mysqli_fetch_array($categories_query)){
                        echo '<option value="' . $row['id_role'] . '" ';
                        if ($trader_info['role'] == $row['id_role']) {
                            echo 'selected disabled';
                        }
                        echo '>' . $row['name'] . '</option>';
                    };
                ?>
            </select>
            <?php
            }?>
        </div>
        <?php
        }?>
    </div>
    <div class="profile-right">
        <div class="profile-item__cont">
            <div class="profile-item__nav">
                <div class="profile-item__nav-active selected">Активные</div>
                <div class="profile-item__nav-archive">Завершённые</div>
            </div>
            <!-- Активные -->
            <div class="profile-item__active">
                <?php
                $num_item = 1;
                
                $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `id_user` = '$id_trader' AND `status` = 'active' ORDER BY `id_ad` DESC");

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
                $num_item = 1;
                
                $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `id_user` = '$id_trader' AND `status` = 'archive' ORDER BY `id_ad` DESC");

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
    </div>
</section>
<?php 
    require('footer.php');
?>