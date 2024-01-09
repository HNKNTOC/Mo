<?php 
    require('header.php');

    $limit = 10;

    $pages_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `status` = 'active'");

    $total = mysqli_num_rows($pages_query);
    $amt = $total / $limit;
?>

<!-- Категории объявлений -->
<div class="item-cont">
    <div class="item-row-title">
        Категории объявлений
    </div>
    <div class="item-free-row dragscroll">
        <a class="category-block" href="search-page.php?id_category=2">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-personal-items.png">    
            </div>
            <div>
                Личные вещи
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=3">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-car.png">    
            </div>
            <div>
                Транспорт
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=4">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-dog.png">    
            </div>
            <div>
                Животные
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=5">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-house.png">    
            </div>
            <div>
                Недвижимость
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=6">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-car-part.png">    
            </div>
            <div>
                Автозапчасти
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=7">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-electonic.png" style="height: 100px; margin-top: 15px;">    
            </div>
            <div>
                Электроника
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=8">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-instruments.png">    
            </div>
            <div>
                Инструменты
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=9">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-hobby.png">    
            </div>
            <div>
                Хобби
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=10">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-cloth.png" style="margin-top: 5px;">    
            </div>
            <div>
                Одежда
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=11">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-home.png">    
            </div>
            <div>
                Для дома и дачи
            </div>
        </a>
        <a class="category-block" href="search-page.php?id_category=1">
            <div>
                <div class="category-circle"></div>
                <img src="img/category-etc.png" style="height: 100px; margin-top: 15px;">    
            </div>
            <div>
                Прочее
            </div>
        </a>
    </div>
</div>
<!-- Объявления "Отдам даром" -->
<div class="item-cont">
    <div class="item-row-title">
        Отдам даром 
        <img src="img/right-angle.png">
    </div>
    <div class="item-free-row dragscroll">
    <?php
        $id_user = $_SESSION['user']['id_user'];

        $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `price` = '0' AND `status` = 'active' ORDER BY `id_ad` DESC LIMIT 10");

        
        while($row = mysqli_fetch_array($ads_query)){    
            $id_ad = $row['id_ad'];
            $img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = '$id_ad' LIMIT 1"));

            echo '
                <div class="item-block">
                    <div class="item-img">
                       <img src="'. $img['path'] .'">
                    </div>
                    <div class="item-text" action="ad.php" method="get" enctype="multipart/form-data">
                        <div class="item-title__cont">
                            <a href="ad.php?id_ad='. $id_ad .'">'.
                                $row['name'].
                            '</a>
                            <input type="text" value="'. $id_ad .'" hidden>';
                            if (isset($_SESSION['user'])){
                                echo '<div class="favorite-add" title="Добавить в избранное">';
                                if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `favorites` WHERE `id_user` = '$id_user' AND `id_ad` = '$id_ad'")) > 0) {
                                    echo '<img src="img/red-heart.png">';
                                }else{
                                    echo '<img src="img/heart.png">';
                                }      
                                echo '</div>';
                            };
            echo        '</div>
                        <div>
                            Бесплатно
                        </div>
                        <div>'.
                            $row['address']
                        .'</div> 
                        <div>'.
                            $row['date']
                        .'</div> 
                        <input type="text" name="id_ad" value="'. $id_ad .'" hidden>
                        <input type="submit" id="id_ad-input" hidden>
                    </div>
                </div>
            ';
            };
    ?>
    </div>
</div>
<!-- Новые объявления -->
<div class="item-cont">
    <div class="item-row-title">
        Новые объявления 
        <img src="img/right-angle.png">
    </div>
    <div class="item-row">
        <?php
            $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `status` = 'active' ORDER BY `id_ad` DESC LIMIT $limit");

            while($row = mysqli_fetch_array($ads_query)){
                if ($row['price'] == 0) {
                    $price = 'Бесплатно';
                }else{
                    $price = $row['price'] . ' ₽';
                }
                
                $id_ad = $row['id_ad'];
                $img = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `images` WHERE `id_ad` = '$id_ad'"));

                echo '
                    <div class="item-block">
                        <div class="item-img">
                            <img src="'. $img['path'] .'">
                        </div>
                        <div class="item-text" action="ad.php" method="get" enctype="multipart/form-data">
                            <div class="item-title__cont">
                                <a href="ad.php?id_ad='. $id_ad .'">'.
                                    $row['name'].
                                '</a>
                                <input type="text" value="'. $id_ad .'" hidden>';
                                if (isset($_SESSION['user'])){
                                    echo '<div class="favorite-add" title="Добавить в избранное">';
                                    if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `favorites` WHERE `id_user` = '$id_user' AND `id_ad` = '$id_ad'")) > 0) {
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
                };
        ?>
    </div>
</div>
<!-- Подгрузка объявлений -->
<div id="showmore-triger" data-page="1" data-max="<?php echo $amt; ?>">
	<div class="loader">
        <div></div>
    </div>
</div>

<?php
    require('footer.php')
?>