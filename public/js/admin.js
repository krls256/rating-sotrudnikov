$(document).ready(function(){
  if($('*').is('#city, #create__file, #type, #position, #company, #filter_moderation, #moderation, #select-castom')){
    $('#type, #city, #create__file, #position, #company, #filter_moderation, #moderation, #select-castom').styler({
      selectSearch: true,
    });
  }

  //функция уведомлений в окне авторизации
  function card__log(text, type){
    let log  = $('.login__error');

    if(type == 'ok'){
      log.addClass('success'); //если успешно авторизоаван показываем зеленую карточку
    }
    log.text(text).css({display:'block'}); //Добавляем текст сообщения и делаем видимым

    //Скрываем блок через 5 секунд
    setTimeout(function () {
      log.text('').css({display:'none'}).removeClass('success');
    }, 5000);
  }

  $('[name="banner"]').on('change', function(){
    var $input = $(this);
    var fd = new FormData;

    fd.append('file', $input.prop('files')[0]);

    $.ajax({
        url: 'function?func=edit_banner',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
          switch (data) {
            case 'file_size':
                card__log('Изображение должно быть 300х400.');
              break;
            case 'file_error':
                card__log('Что-то пошло не так!');
              break;
            default:
              card__log('Вы успешно обновили баннер.', 'ok');
          }
        }
    });
  });

  // Форма логина
  $('.login__form').on('submit', function(e){
    console.log('.login__form submitted');
    let elem = $(this);

    //если в поля авторизации введено менее 3 сиволов, говорим об этом
    if((elem.find('[name="login"]').val().length > 3) || (elem.find('[name="password"]').val().length > 3)){
      $.ajax({
        type: "POST",
        url:'function?func=login',
        data: elem.serialize(),
        cache: false,
        success: function(res){
          switch (res) {
            case 'user':
              card__log('Пользователь не найден!');
              break;
            case 'pass':
              card__log('пароль введен не верно!');
              break;
            case 'ok':
              card__log('Вы успешно авторизованы.', 'ok');
              window.location.href = '/admin';
              break;
          }
        }
      });
    }else{
      card__log("Одно из полей заполнено не верно");
    }
    e.preventDefault();
    return false;
  });

  var files; //Записываем файл

  $('.create input[type=file], .articals[type="file"]').on('change', function(){
	   files = this.files;
  });
  
  // Создание компании
  $('.create').on('submit', function(e){
    console.log('.create submitted');
    e.stopPropagation(); // Остановка происходящего
    e.preventDefault();  // Полная остановка происходящего

    let elem       = $(this),
        file__data = new FormData(elem.get(0)), //Перезаписываем форму что бы добавить file
        status     = true,
        type       = elem.data('type');

    //Проверяем поля на пустоту
    elem.find('[data-check="true"]').each(function(){
      if( $(this).val().length == '' ){
        status = false;
      }
    });

    let url = type==1?'create-company':'edit_company';

    if(status == true){
      $.ajax({
        type: 'POST',
        contentType: false,
        processData : false,
        url: 'function?func=' + url,
        data: file__data,
        cache: false,
        success: function(res) {
          switch (res) {
            case 'file_error':
              card__log('Ошибка загрузки файла.');
              break;
            case 'file_size':
              card__log('Размер логотипа не должен привышать 2 мб. и быть не больше 50х50 px.');
              break;
            case 'yell_error':
              card__log('Такой yell ID уже зарегистрирован.');
              break;
            case 'flamp_error':
              card__log('Такой flamp ID уже зарегистрирован.');
              break;
            case 'input_error':
              card__log('Пожалуйста заполните все поля.');
              break;
            case 'fatal':
              card__log('Что-то пошло не так...');
              break;
            case 'ok':
              if(type == 1){
                card__log('Компания успешно добавлена.', 'ok');
                elem.find('input[type="text"], textarea, input[type="file"], input[type="hidden"], .jq-file__name').val('');
                elem.find('.jq-file__name').text('Файл не выбран');
                elem.find('#map').text('');
                adminMap();
                $('.content').animate({scrollTop:0}, 500);
              }else{
                card__log('Данные компании успешно обновлены!', 'ok');
                $('.content').animate({scrollTop:'5px'}, 500);
              }
              break;
          }
        }
      });
    }else{
      card__log('Заполните все поля.');
    }

    return false;
  });


  // Отключить отзыв
  $('.review-bottom .submit--red, .comment-bottom .submit--red').on('click', function(){
    let id  = $(this).data('id'),
        key = $(this).data('key'),
        type = $(this).data('type');

    if(!$(this).closest('.block').find('*').is('.warning')){
      $(this).closest('.block')
        .append(
          '<div class="warning comment_wer">' +
            '<span>Вы уверены? После удаления заявку нельзя восстановить.</span>' +
            '<form action="/admin/review/delete.php" method="POST"><input type="hidden" name="id" value="'+ id + '"><button data-id="'+id+'" data-key="'+key+'" data-type="'+type+'">Да</button data-id="'+id+'" data-key="'+key+'" data-type="'+type+'"></form>' +
            '<div>Нет</div>' +
          '</div>');
    }
  });

  $(document).on('click', '.warning > div:last-child', function(){
    $(this).closest('.warning').remove();
  });

  // // Удаляем отзыв
  // $(document).on('click', '.comment_wer > div:nth-child(2), .save-dal', function(e){
  //   var el    = $(this),
  //       block = el.closest('.block'),
  //       key   = el.data('key'),
  //       id    = el.data('id'),
  //       type  = el.data('type'),
  //       url   = type==1?'review-del':'comment-del';
  //
  //    $.post('function?func='+url, {id: id, key: key}, function(res){
  //      if(res == 'ok'){
  //        if(el.hasClass('save-dal') == true){
  //          window.location = '/admin/moderation?type=user';
  //        }else{
  //          block.remove();
  //        }
  //      }else{
  //        if(!block.find('.login__error').length){
  //          block.find('.text-review').prepend('<div class="login__error">'+res+'</div>')
  //          block.find('.login__error').css({'display':'block'});
  //        }else{
  //          block.find('.login__error').text(res);
  //        }
  //      }
  //    });
  //
  //    e.preventDefault();
  // });

  /**
   * Редактирование отзывов сотрудников
   */
  $('.review-hr-edit').on('submit', function(e) {
    console.log('.review-hr-edit submitted');
    e.preventDefault();

    var $this = $(this);

    $this.find('input[type="text"][required], textarea[required]').map(function(e, i) {
      if ( $(this).val().length == 0 ) 
        return card__log('Заполните все поля.');
    });
    // $(this).unbind('submit').submit();
    $.post('review/update.php', $this.serialize())
      .then(function(e) {
        const response = JSON.parse(e);
        if (response.status == 'ok')
          card__log('Отзыв успешно обновлен.', 'ok');
        else
          card__log('Что-то пошло не так.');
      });
  });

  /**
   * Удаление отзывов сотрудников
   */
  $('.hr-rev-dal').on('click', function() {
    var $this = $(this); 
    var id    = $this.data('id');
    
    if ( id.length == '' )
      return card__log('Что-то пошло не так.');

    $.post('function?func=review-hr-del', {id: id})
      .then(function(e) { 
        card__log('Отзыв успешно удален.', 'ok');
        $this.closest('form').remove();
      });
  });

  $('.create_review_name').on('submit', function(e){
    console.log('.create_review_name submitted');
    e.stopPropagation(); // Остановка происходящего
    e.preventDefault();  // Полная остановка происходящего
    console.log('hello');
    let elem = $(this),
        status = true;

    //Проверяем поля на пустоту
    elem.find('input[type="text"], [name="text"]').each(function(){
      if($(this).val().length == ''){
        status = false;
      }
    });
    $(this).unbind('submit').submit();
    return;

    if(status == true){
      $.ajax({
        type: 'POST',
        url: 'review/store.php',
        data: elem.serialize(),
        cache: false,
        success: function(res){
          switch (res) {
            case 'text_error':
              card__log('Заполните все поля.');
              break;
            case 'sql_error':
              card__log('Что-то пошло не так...');
              break;
            case 'ok':
              card__log('Статья успешно добавлена.', 'ok');
              elem.find('input[type="text"], .jq-file__name').val('');
              elem.find('textarea').val('');
              break;
          }
        }
      });
    }else{
      card__log('Заполните все поля.');
    }

  });

  $('.company-edit__del').on('click', function(){
    let id  = $(this).data('id'),
        key = $(this).data('key');

    $(this).closest('.block')
      .append('<div class="warning company_war"><span>Вы уверены? После удаления компанию нельзя восстановить.</span><div data-id="'+id+'" data-key="'+key+'">Да</div><div>Нет</div></div>');

    return false;
  });

  $(document).on('click', '.company_war > div:nth-child(2)', function(){
    let id    = $(this).data('id'),
        block = $(this).closest('.block'),
        key   = $(this).data('key');

        $.post('function?func=del_company', {id: id, key: key}, function(res){
          if(res == 'ok'){
            block.remove();
          }else{
            if(!block.is('.login__error')){
              block.prepend('<div class="login__error">'+res+'</div>');
            }else{
              block.find('.login__error').text(res);
            }
          }
        });
  });

  $('.save-review').on('click', function(e){
    console.log('.save-review submitted');
    e.stopPropagation(); // Остановка происходящего
    e.preventDefault();  // Полная остановка происходящего

    var el   = $(this).closest('form'),
        test = true,
        type = $(this).data('method');

    el.find('input[type="text"], textarea, select').each(function(){
      if($(this).val() == ''){
        test = false;
      }
    });

    if(test){
      $.post('function?func=review_edit', el.serialize()+"&method="+type, function(res){
        if(res == 'ok'){
          window.location = 'moderation?type=user';
        }else{
          card__log(res);
        }
      });
    }else{
      card__log('Заполните все поля.');
    }

  });

  //Обработка настроек сайта
  $('.edit-index').on('submit', function(e){
    console.log('.edit-index submitted');
    e.stopPropagation(); // Остановка происходящего
    e.preventDefault();  // Полная остановка происходящего

    var is = $(this);
    var data = is.serialize();
    
    $.ajax({
      type: 'POST',
      url: 'function?func=edit_setting',
      data: data,
      beforeSend: function(){
        //code...
      },
      success:function(res){
        var log = $('.index_log');      
        if ( res.res == 'ok'){
            is.find('[name]').removeClass('error');

            log.addClass('success');
            log.text('Сохранино!');
        } else {
          for (var i=0; i < res['error'].length;i++) {
            $('[name='+res['error'][i]+']').addClass('error');

            log.removeClass('success');
            log.css({'display':'block'});
            log.text('Заполнены не все поля!');
          }
        } 
      }
    });

  });

  $('#filter_moderation').on('change', function(e){
    window.location = 'moderation?id=' + $(this).val();
  });

  $('.advice').on('submit', function(){
    var chek = true;

    if($(this).find('[data-check="true"]').val() == ''){
      chek = false;
    }

    if(chek === true){
      $.post('function?func=advice', $(this).serialize(), function(req){
        if(req == 'ok'){
          card__log('Советы обновлены.', 'ok');
        }
      });
    }else{
      card__log('Должно быть как минимум 2 совета.');
    }
  });
});
