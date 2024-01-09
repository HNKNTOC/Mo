$(document).ready(function () {
  //Автозаполнение полей адресов
  var token = "2b91ef7631cc1470385828db04e4ba83d8dd7b5c";

  $(".address").suggestions({
      token: token,
      type: "ADDRESS",
      // onSelect: function(suggestion) {
      //     console.log(suggestion);
      // }
  });
  

  //Изменение стиля активного инпута на странице размещения объявления
  $('#price').focus(function(){
    $('.price').toggleClass('input-active');
  });

  $('#price').blur(function(){
    $('.price').toggleClass('input-active');
  });

  // Бургер
  $(".burger").click(function() {
      $(".user").toggleClass("active");
    });
  
  //Меню навигации в личном кабинете
  $(".profile-nav__1").click(function() {
    $(".profile-nav__1").addClass("nav-active");
    $(".profile-nav__2").removeClass("nav-active");
    $(".profile-nav__3").removeClass("nav-active");
    $(".profile-nav__4").removeClass("nav-active");

    $(".profile-item__cont").removeClass("disable");
    $(".profile-reviews__cont").addClass("disable");
    $(".profile-favorite__cont").addClass("disable");
    $(".profile-settings__cont").addClass("disable");
  });

  $(".profile-nav__2").click(function() {
    $(".profile-nav__1").removeClass("nav-active");
    $(".profile-nav__2").addClass("nav-active");
    $(".profile-nav__3").removeClass("nav-active");
    $(".profile-nav__4").removeClass("nav-active");

    $(".profile-item__cont").addClass("disable");
    $(".profile-reviews__cont").removeClass("disable");
    $(".profile-favorite__cont").addClass("disable");
    $(".profile-settings__cont").addClass("disable");
  });

  $(".profile-nav__3").click(function() {
    $(".profile-nav__1").removeClass("nav-active");
    $(".profile-nav__2").removeClass("nav-active");
    $(".profile-nav__3").addClass("nav-active");
    $(".profile-nav__4").removeClass("nav-active");

    $(".profile-item__cont").addClass("disable");
    $(".profile-reviews__cont").addClass("disable");
    $(".profile-favorite__cont").removeClass("disable");
    $(".profile-settings__cont").addClass("disable");
  });

  $(".profile-nav__4").click(function() {
    $(".profile-nav__1").removeClass("nav-active");
    $(".profile-nav__2").removeClass("nav-active");
    $(".profile-nav__3").removeClass("nav-active");
    $(".profile-nav__4").addClass("nav-active");

    $(".profile-item__cont").addClass("disable");
    $(".profile-reviews__cont").addClass("disable");
    $(".profile-favorite__cont").addClass("disable");
    $(".profile-settings__cont").removeClass("disable");
  });

  //Навигация в профиле моих объявлений
  $(".profile-item__nav-active").click(function() {
    $(".profile-item__nav-active").addClass("selected");
    $(".profile-item__nav-archive").removeClass("selected");

    $(".profile-item__active").removeClass("disable");
    $(".profile-item__archive").addClass("disable");
  });

  $(".profile-item__nav-archive").click(function() {
    $(".profile-item__nav-active").removeClass("selected");
    $(".profile-item__nav-archive").addClass("selected");

    $(".profile-item__active").addClass("disable");
    $(".profile-item__archive").removeClass("disable");
  });

  //Отзывы о пользователе
  $(".close").click(function() {
    $(".reviews").addClass("disable");
    $(".review-add__cont").addClass("disable");
    $(".location-cont").addClass("disable");
    $(".admonition").addClass("disable");
  });

  $(".admonition-btn").click(function (e) { 
    $(".admonition").removeClass("disable");
  });

  $(".profile-rating").click(function() {
    $(".reviews").removeClass("disable");
  });
  $(".seller-rating").click(function() {
    $(".reviews").removeClass("disable");
  });
  $('.review-add__btn').click(function (e) { 
    $(".reviews").addClass("disable");
    $(".review-add__cont").removeClass("disable");
  });
  $('.usr-reviews').click(function (e) { 
    $(".reviews").removeClass("disable");
  });
  $('.location-btn').click(function (e) { 
    $(".location-cont").removeClass("disable");
  });
  

  //Открытие окна смены аватарки
  $(".profile-ava-change").click(function() {
    $(".profile-ava-change__dialog").removeClass("disable");
  });

  $(document).on("mouseup", function(e){
    let s = $(".profile-ava-change__dialog");
    if(!s.is(e.target) && s.has(e.target).length === 0) {
      s.addClass("disable");
    }
    s = $(".user");
    if(!s.is(e.target) && s.has(e.target).length === 0) {
      s.removeClass("active");
    }
    s = $(".delete-ad_window");
    if(!s.is(e.target) && s.has(e.target).length === 0) {
      s.addClass("disable");
    }

    s = $(".profile_ad-actions_window");
    if(!s.is(e.target) && s.has(e.target).length === 0) {
      s.addClass("disable");
    }
  });
  
  //Загрузка фото на странице размещения объявления
  $('#img').change(function (input) { 
    $('.preview-images').text('Файлы выбраны');
  });
  
  //Взаимодействие с объявлением в личном кабинете
  $('.profile_ad-actions_btn').click(function () { 
    $('.profile_ad-actions_window').addClass('disable');
    $(this).next().removeClass('disable');
  });

  //Слайдер на странице объявления
  $('.label-slide').click(function () { 
    $('.label-slide').removeClass('label-active');
    $(this).addClass('label-active'); 
  });

  let parent = $(".slides-list")[0];
  let num_slide = 0;

  $(".slides-list").click(function (e) {
    let target = e.target || e.srcElement;
    for(let i = 0; i < parent.children.length; i++) {
        if(parent.children[i] == target) num_slide = i;  
    }

    $('.slides-cont').css('transform', 'translate(-' + num_slide*100 + '%)')
  });
  
  //Маска ввода при регистрации
  $('.tel').mask('+7 (999) 999-99-99');

  //Показ номера телефона на странице объявления
  $('.number').click(function (e) { 
    $('.number-tel').removeClass('disable');
    $('.number-text').addClass('disable');
  });

  //Проверка совпадения паролей
  $('.pass').keyup(function (e) { 
    let pass1 = $('.pass1').val();
    let pass2 = $('.pass2').val();

    if (pass1 != pass2 || pass1 == '' || pass2 == '') {
      $('.pass').css({
        "border": "1px solid red",
      });
      $('.submit').prop('disabled', true);
      $('.submit').css("cursor", "default");
    }else{
      $('.pass').css({
        "border": "1px solid black",
      });
      $('.submit').prop('disabled', false);
      $('.submit').css("cursor", "pointer");
    }
  });

  //Анимация сообщения об ошибке
  $('.err__msg.active').delay(5000).slideUp(500);

  //Показ поля поиска
  $('.search-show-btn').click(function (e) { 
    $('.logo').hide();
    $('.search-show-btn').hide();
    $('.search').css("display", "flex");
  });

  //Скрытие поля поиска
  $('.close-srch').click(function (e) { 
    $('.logo').show();
    $('.search-show-btn').show();
    $('.search').css("display", "none");
  });

});