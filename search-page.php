<?php 
    require('header.php');

    $id_category = $_GET['id_category'];
    $srch_str = mb_strtolower($_GET['srch_str'], 'utf-8');
    $limit = 20;
    
    $min_price = $_GET['min_price'];
    $max_price = $_GET['max_price'];

    if ($min_price == '' || (!isset($_GET['min_price']))) {
        $min_price = 0;
    };
    if ($max_price == '' || (!isset($_GET['max_price']))) {
        $max_price = 99999999999999999;
    };

    if ($id_category != '') {
        if ($srch_str != ''){
            $pages_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND (`price` BETWEEN '$min_price' AND '$max_price')");
        }else{
            $pages_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND `status` = 'active' AND (`price` BETWEEN '$min_price' AND '$max_price')");
        }
        
    }elseif ($srch_str != ''){
        $pages_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND (`price` BETWEEN '$min_price' AND '$max_price')");
    }else{
        $pages_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `status` = 'active' AND (`price` BETWEEN '$min_price' AND '$max_price')");
    };

    $total = mysqli_num_rows($pages_query);
    $amt = $total / $limit;
?>

<!-- Категории объявлений -->
<section class="search-cont">
    <form class="categories-cont" action="search-page.php" method="get" enctype="multipart/form-data">
        <div class="categories-title">
            Категории объявлений
        </div>
        <div class="categories-menu">
            <select name="id_category" id="categories-select">
                <?php
                    $categories_query = mysqli_query($connect, "SELECT * FROM `categories`");
    
                    while($row = mysqli_fetch_array($categories_query)){
                      echo '<option value="' . $row['id_category'] . '"';
                        if ($row['id_category'] == $id_category) {
                            echo 'selected disabled';
                        }
                      echo '>' . $row['name'] . '</option>';
                    };
                ?>
            </select>
        </div>
        <div class="categories-title">
            Цена
        </div>
        <div class="categories-price">
            <input type="number" placeholder="От" name="min_price" min="0" value="<?php echo $_GET['min_price'];?>">
            -
            <input type="number" placeholder="До" name="max_price" min="0" value="<?php echo $_GET['max_price'];?>">
            <input type="text" name="srch_str" value="<?php echo $_GET['srch_str'];?>" hidden>
            <input type="submit" id="price" hidden>
        </div>
        <label for="price" class="categories-btn">
            Показать
        </label>
    </form>
    <!-- Результат поиска -->
    <div class="search-result-cont">
        <div class="title">Объявления в вашем городе</div>
        <div class="item-row">
            <?php
                $id_user = $_SESSION['user']['id_user'];
                if ($id_category != '') {
                    if ($srch_str != ''){
                        $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND `address` LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC");
                    }else{
                        $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND `status` = 'active' AND `address` LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC");
                    }
                }elseif ($srch_str != ''){
                    $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND `address` LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC");
                }else{
                    $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `status` = 'active' AND `address` LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC");
                }
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
                            <div class="item-text">
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
                
                if (mysqli_num_rows($ads_query) < 1) {?>
                    <div class="no-items">
                        <p>Объявлений нет &#9785;</p>
                    </div>
<?php           }
            ?>
            </div>
            <div class="title">Объявления в других городах</div>
            <div class="item-row loading-here">
            <?php                                        
                    if ($id_category != '') {
                        if ($srch_str != ''){
                            $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND `address` NOT LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC LIMIT $limit");
                        }else{
                            $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND `status` = 'active' AND `address` NOT LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC LIMIT $limit");
                        }
                    }elseif ($srch_str != ''){
                        $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND `address` NOT LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC LIMIT $limit");
                    }else{
                        $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `status` = 'active' AND `address` NOT LIKE '%$town%' AND (`price` BETWEEN '$min_price' AND '$max_price') ORDER BY `id_ad` DESC LIMIT $limit");
                    }
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
                                <div class="item-text">
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

                        if (mysqli_num_rows($ads_query) < 1) {?>
                            <div class="no-items">
                                <p>Объявлений нет &#9785;</p>
                            </div>
        <?php           }
            ?>
            
        </div>
        <!-- Подгрузка объявлений -->
        <div id="showmore-triger__search-page" data-page="1" data-max="<?php echo $amt; ?>">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
</section>
<?php
    require('footer.php')
?>