<?php
    require('header.php');
    
    $id_ad = $_GET['id_ad'];
    $id_user = $_SESSION['user']['id_user'];

    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `ads_views` WHERE `id_ad` = '$id_ad' AND `id_user` = '$id_user'")) < 1) {
        mysqli_query($connect, "INSERT INTO `ads_views` (`id_ad`, `id_user`) VALUES ('$id_ad', '$id_user')");
    }

    $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `id_ad` = '$id_ad'");

    $ad_info = mysqli_fetch_array($ads_query);

    $desc = $ad_info['description'];
    $address = $ad_info['address'];
    $id_trader = $ad_info['id_user'];
    
    $trader_info = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = '$id_trader'"));

    if ($ad_info['price'] == 0) {
        $price = 'Бесплатно';
    }else{
        $price = $ad_info['price'] . ' ₽';
    }
?>
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
<section class="cont-main-info">
    <!-- Фото объявления -->
    <div class="slider">
        <!-- Название объявления -->
        <div class="name">
            <div class="name-text">
                <?echo $ad_info['name'];?>
                <div class="price">
                    <?php
                        echo $price;
                        
                        $id_user = $ad_info['id_user'];

                        $user_info = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id_user` = $id_user"));
                    ?>
                </div>
            </div>
            
            <div class="ad-date">
                <div>
                    <?echo $ad_info['date'];?>
                </div>
                <div>
                    <img src="img/eye.png">
                    <?php
                        $views_query = mysqli_query($connect, "SELECT * FROM `ads_views` WHERE `id_ad` = '$id_ad'");
                        echo mysqli_num_rows($views_query);
                    ?>
                </div>
            </div>
        </div>
        <div class="main-slide">
            <div class="slides-cont">
                <?php
                    $img_query = mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = $id_ad");

                    $num_slide = 1;

                    while($row = mysqli_fetch_array($img_query)){
                        echo '
                            <div class="slides">
                                <div class="blur" style="background: url('.$row['path'].');"></div>
                                <img src="'.$row['path'].'">
                            </div>
                        ';

                        $num_slide++;
                        };
                ?>
            </div>
        </div>
        <div class="slides-list">
            <?php
                $num_slide = 1;
                $img_query = mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = $id_ad");

                while($row = mysqli_fetch_array($img_query)){
                    echo '
                        <div class="label-slide ';
                    if ($num_slide == 1) echo 'label-active';
                    echo '">
                            <img src="'.$row['path'].'">
                        </div>
                    ';

                    $num_slide++;
                    };
            ?>
        </div>
    </div>
    <!-- Взаимодействие с объявлением -->
    <div class="ad-actions">
        
        <input type="text" value="<?php echo $id_ad;?>" hidden>
        <?php
            if (isset($_SESSION['user'])){
                $id_user = $_SESSION['user']['id_user'];

                echo '<div class="ad-actions-favorite favorite-add">';
                    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `favorites` WHERE `id_user` = '$id_user' AND `id_ad` = '$id_ad'")) > 0) {
                        echo '<img src="img/red-heart.png"> Удалить из избранного';
                    }else{
                        echo '<img src="img/heart.png"> Добавить в избранное';
                    }  
                echo '
                </div>';
            }
        ?>
        <div class="seller">
            <div class="seller-ava">
                <img src="uploads/<?echo $user_info['ava']?>">
            </div>
            <div>
                <a href="<?php
                    if ($id_trader == $_SESSION['user']['id_user']) {
                        echo 'profile.php';
                    }else{
                        echo 'profile__another-user.php?id_user='. $id_trader;
                    }
                ?>">
                    <?php
                        echo $user_info['name'] . ' ' . $user_info['surname'];
                    ?>
                </a>
                <div class="seller-rating">
                    <div>
                        <img src="img/star.png">
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
                        <?php echo round($rating, 1); ?>
                    </div>
                    <div>
                    <?php
                        $count_reviews = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `reviews` WHERE `id_trader` = '$id_trader'"));

                        echo '('.$count_reviews.' отзыва)';
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="number">
            <div class="number-tel disable" <?php if (!isset($_SESSION['user'])) {echo 'style="background: rgb(207, 57, 57);"';}?>>
                <?php 
                    if (isset($_SESSION['user'])) {
                        echo $trader_info['telephone'];
                    }else{
                        echo 'Необходима авторизация';
                    };
                ?>
            </div>
            <div class="number-text">Показать номер</div>
        </div>
        <div class="ad-adress">
            <img src="img/pin.png">
            <?echo $address;?>
        </div>
    </div>
</section>
<!-- Информация об объявлении -->
<section class="cont-info">
    <div class="ad-info">
        <div class="title">
            Адрес
        </div>
        <div class="text">
            <?echo $address;?>
        </div>
        <div class="line"></div>
        <div class="title">
            Описание
        </div>
        <div class="text">
            <?echo $desc;?>
        </div>
        <div class="line"></div>
    </div>
    <!-- Похожие объявления -->
    <div class="similar-item">
        <div class="title">
            Похожие объявления
        </div>
        <div class="similar-item-cont">
            <?php                
                $category = $ad_info['category'];
                
                    
                $similar_ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$category' AND `id_ad` <> '$id_ad' AND `status` = 'active' LIMIT 10");

                while ($row = mysqli_fetch_array($similar_ads_query)) {
                    if ($row['price'] == 0) {
                        $price = 'Бесплатно';
                    }else{
                        $price = $row['price'] . ' ₽';
                    }

                    $id_similar_ad = $row['id_ad'];


                    $img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = '$id_similar_ad' LIMIT 1"));

                    echo '
                        <div class="item-block">
                            <div class="item-img">
                                <img src="'.$img['path'].'">
                            </div>
                            <div class="item-text">
                                <div class="item-title__cont">
                                    <a href="ad.php?id_ad='. $id_similar_ad .'">'.
                                        $row['name'].
                                    '</a>
                                    <input type="text" value="'. $id_similar_ad .'" hidden>';
                                    if (isset($_SESSION['user'])){
                                        $id_user = $_SESSION['user']['id_user'];
                                        echo '<div class="favorite-add" title="Добавить в избранное">';
                                        if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `favorites` WHERE `id_user` = '$id_user' AND `id_ad` = '$id_similar_ad'")) > 0) {
                                            echo '<img src="img/red-heart.png">';
                                        }else{
                                            echo '<img src="img/heart.png">';
                                        }      
                                        echo '</div>';
                                    };
                    echo        '</div>
                                <div>'.
                                    $price
                                .'</div>
                                <div>'.
                                    $row['address']
                                .'</div> 
                                <div>'.
                                    $row['date']
                                .'</div> 
                            </div>
                        </div>
                    ';
                }
                if (mysqli_num_rows($similar_ads_query) < 1) {?>
                    <div class="no-items">
                        <p>Объявлений нет &#9785;</p>
                    </div>
<?php           }
            ?>
        </div>
    </div>
</section>
<?php
    require('footer.php')
?>