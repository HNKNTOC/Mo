<?php
    require('header.php');
?>
<!-- Поля ввода информации о новом объявлении -->
<section class="cont">
    <form class="new-ad-info" action="vendor/post-ad.php" method="post" enctype="multipart/form-data">
        <div class="input-cont">
            <div class="input-title" maxlength="500">
                Название объявления
            </div>
            <input type="text" name="name" required>
        </div>
        <div class="input-cont">
            <div class="input-title">
                Категория
            </div>
            <select name="category">
                <?php
                    $categories_query = mysqli_query($connect, "SELECT * FROM `categories`");
    
                    while($row = mysqli_fetch_array($categories_query)){
                      echo '<option value="' . $row['id_category'] . '">' . $row['name'] . '</option>';
                    };
                ?>
            </select>
        </div>
        <div class="input-cont">
            <div class="input-title">
                Адрес
            </div>
            <input type="text" class="address" name="address" placeholder="Начните вводить адрес, а затем выберите из списка" required>
        </div>
        <div class="input-cont">
            <div class="input-title">
                Описание
            </div>
            <textarea class="description" maxlength="5000" name="description"></textarea>
        </div>
        <div class="input-cont price-cont">
            <div class="input-title">
                Цена
            </div>
            <label for="price" class="price">
                <input type="number" id="price" name="price" min="0" max="99999999">
                <span>₽</span>
            </label>
        </div>
        <div class="input-cont file-cont">
            <div class="input-title">
                Фото
            </div>
            <div class="file-label-cont">
                <input class="file-input" type="file" id="files" name="files[]" accept="image/png, image/jpeg" multiple required>
            </div>
        </div>
        <div class="post">
            <label for="post-ad" class="post-btn">
                Разместить
            </label>
            <input type="submit" id="post-ad" hidden>
        </div>
    </form>
</section>

<?php
    require('footer.php');
?>