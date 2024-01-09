$(document).ready(function () {
    //Удаление объявления
    $('.delete-ad').click(function () { 
        let id_ad = $(this).parent().find('input').val();


        fd = new FormData;
        fd.append('id_ad', id_ad);
        $.ajax({
            url: '../vendor/delete-ad.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () {
              location.reload();
            }
        });
      });

    //Завершение объявления
    $('.complete-ad').click(function () { 
        let id_ad = $(this).parent().find('input').val();


        fd = new FormData;
        fd.append('id_ad', id_ad);
        $.ajax({
            url: '../vendor/archiving-ad.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () {
              location.reload();
            }
        });
      });
    
    //Публикация архивного объявления
    $('.post-ad_btn').click(function () { 
        let id_ad = $(this).parent().find('input').val();


        fd = new FormData;
        fd.append('id_ad', id_ad);
        $.ajax({
            url: '../vendor/post-archive-ad.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () {
              location.reload();
            }
        });
      });

    
    $('body').delegate(".favorite-add", "click", function () { 
      let elm = this;
      let id_ad = $(elm).parent().find('input').val();
      let id_user = $('#id_user_inHeader').val();

      if ($(elm).children().attr('src') == 'img/heart.png') {
        //Добавление объявления в избранное
        $(elm).children().attr('src', 'img/red-heart.png');

        fd = new FormData;
        fd.append('id_user', id_user);
        fd.append('id_ad', id_ad);
        $.ajax({
            url: '../vendor/favorite-add.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () {
            }
        });
      }else{
        //Удаление объявления из избранного
        $(elm).children().attr('src', 'img/heart.png');

        fd = new FormData;
        fd.append('id_user', id_user);
        fd.append('id_ad', id_ad);
        $.ajax({
            url: '../vendor/favorite-remove.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function () { 
            }
        });
      }
    });


    //Удаление объявления из избранного в личном кабинете
    $('.favorites-remove').click(function () { 
      let elm = this;
      let id_ad = $(elm).parent().find('input').val();
      let id_user = $('#id_user_inHeader').val();

      fd = new FormData;
      fd.append('id_user', id_user);
      fd.append('id_ad', id_ad);
      $.ajax({
          url: '../vendor/favorite-remove.php',
          data: fd,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function () { 
            location.reload();
          }
      });
      
    });

    //Добавленине отзыва на продавца
    $('.review-add__submit').click(function () { 
      let id_trader = $('#id_trader').val();
      let id_user = $('#id_user_inHeader').val();
      let text_rev = $('#text_rev').val();
      let rating = $('.rating:checked').val();

      fd = new FormData;
      fd.append('id_trader', id_trader);
      fd.append('id_user', id_user);
      fd.append('text_rev', text_rev);
      fd.append('rating', rating);
      $.ajax({
          url: '../vendor/review-add.php',
          data: fd,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function () {
            location.reload();
          }
      });
      
    });
    
    //Удаление отзыва
    $('.profile-reviews__delete').click(function () { 
      let elm = this;
      let id_rev = $(elm).parent().find('input').val();

      fd = new FormData;
      fd.append('id_rev', id_rev);
      $.ajax({
          url: '../vendor/review-delete.php',
          data: fd,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function () {
            location.reload();
          }
      });
    });

  //Подгрузка объявлений при скролле
  var block_show = false;
 
  function scrollMore(){
    var $target = $('#showmore-triger');
    
    if (block_show) {
      return false;
    }
   
    var wt = $(window).scrollTop();
    var wh = $(window).height();
    var et = $target.offset().top;
    var eh = $target.outerHeight();
    var dh = $(document).height();   
   
    if (wt + wh >= et || wh + wt == dh || eh + et < wh){
      var page = $target.attr('data-page');	
      page++;
      block_show = true;
   
      $.ajax({ 
        url: '../vendor/load-items.php?page=' + page,  
        dataType: 'html',
        success: function(data){
          $('.item-cont .item-row').append(data);
          block_show = false;
          $target.attr('data-page', page);
          if (page >=  $target.attr('data-max')) {
            $target.remove();
          }
        }
      }); 
    }
  };
  
  $(window).scroll(function(){
    if (window.location.pathname == '/index.php'){
      scrollMore();
    }else if (window.location.pathname == '/search-page.php'){
      scrollMoreSrchPage();
    }
  });
    
  $(document).ready(function(){ 
    if (window.location.pathname == '/index.php'){
      scrollMore();
    }else if (window.location.pathname == '/search-page.php'){
      scrollMoreSrchPage();
    }
  });

  //Подгрузка объявлений при скролле на странице поиска
  var block_show__srchPage = false;
 
  function scrollMoreSrchPage(){
    var $target = $('#showmore-triger__search-page');
    
    if (block_show__srchPage) {
      return false;
    }
   
    var wt = $(window).scrollTop();
    var wh = $(window).height();
    var et = $target.offset().top;
    var eh = $target.outerHeight();
    var dh = $(document).height();   
   
    if (wt + wh >= et || wh + wt == dh || eh + et < wh){
      var page = $target.attr('data-page');	
      page++;
      block_show__srchPage = true;
   
      $.ajax({ 
        url: '../vendor/search-page-load-items.php?page=' + page,  
        dataType: 'html',
        success: function(data){
          $('.loading-here').append(data);
          block_show__srchPage = false;
          $target.attr('data-page', page);
          if (page >=  $target.attr('data-max')) {
            $target.remove();
          }
        }
      }); 
    }
  };
 
  //Изменение роли пользователя на странице другого пользователя
  $('.change-user-role').change(function (e) { 
    let id_user = $(this).parent().find('input').val();
    let id_role = $('.change-user-role').val();

    fd = new FormData;
    fd.append('id_user', id_user);
    fd.append('id_role', id_role);
    $.ajax({
        url: '../vendor/change-user-role.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function () {
          location.reload();
        }
    });
  });

  //Бан пользоватлея
  $('.ban-user').click(function (e) { 
    let id_user = $(this).parent().find('input').val();

    fd = new FormData;
    fd.append('id_user', id_user);
    $.ajax({
        url: '../vendor/ban-user.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function () {
          location.reload();
        }
    });
  });

  //Снятие бана с пользоватлея
  $('.unban-user').click(function (e) { 
    let id_user = $(this).parent().find('input').val();

    fd = new FormData;
    fd.append('id_user', id_user);
    $.ajax({
        url: '../vendor/unban-user.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function () {
          location.reload();
        }
    });
  });

  //Удаление предупреждения
  $('body').delegate(".delete-admonition", "click", function () { 
    let id_admonition = $(this).parent().find('input').val();

    fd = new FormData;
    fd.append('id_admonition', id_admonition);
    $.ajax({
        url: '../vendor/admonition-delete.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function () {
          location.reload();
        }
    });
  });




});