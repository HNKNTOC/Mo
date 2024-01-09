<?php
require_once('connect.php');

$limit = 20; 
$id_category = $_GET['id_category'];
$srch_str = mb_strtolower($_GET['srch_str'], 'utf-8');
$town = $_SESSION['town'];

// Получение записей для текущей страницы
$page = $_GET['page'];
if ($page == '') {
    $page = 1;
};	
if ($page != 1) {
    $start = $page * $limit - $limit;
};
if (isset($id_category)) {
    $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `category` = '$id_category' AND `status` = 'active' AND `address` NOT LIKE '%$town%' ORDER BY `id_ad` DESC LIMIT $start, $limit");
}elseif ($srch_str != ''){
    $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE (`name` LIKE '%$srch_str%' OR `description` LIKE '%$srch_str%') AND `status` = 'active' AND `address` NOT LIKE '%$town%' ORDER BY `id_ad` DESC LIMIT $start, $limit");
}else{
    $ads_query = mysqli_query($connect, "SELECT * FROM `ads` WHERE `status` = 'active' AND `address` NOT LIKE '%$town%' ORDER BY `id_ad` DESC LIMIT $start, $limit");
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