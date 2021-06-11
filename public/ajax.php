<?php
  include "function.php";

  $set = setting($PDO);

  # Публикация отзывов
  if($_GET['func'] == 'new_reviews')
  {
    # Проверяем капчу
    if(!captcha($_POST['id'], $_POST['key'], $_POST["g-recaptcha-response"]))
      exit('Капча не пройдена.');

    # Проверяем есть ли в запросе тип отзыва
    if ($_POST['review-positiv'] == '' or $_POST['review-neg'] == '')
      exit('Пожалуйста оставте свой отзыв.');

    $text = "<p><strong>Плюсы: </strong>" . trim($_POST['review-positiv']) . "</p><p><strong>Минусы: </strong>" . trim($_POST['review-neg']) . "</p>";

    $req = [
      'position'    => trim($_POST['position']),
      'discription' => htmlspecialchars(addslashes($text)),
      'rev'         => (int) $_POST['like'],
      'date'        => time(),
      'id_com'      => (int) $_POST['id'],
      'moderation'  => $set['moderation']
    ];

    # Проверяем пустые поля
    if($req['position'] == '' or $req['discription'] == '' or $req['like'])
      exit('Пожалуйста заполните все поля.');

    try{
      $query  = $PDO->prepare("INSERT INTO `review`(`position`, `rev`, `pars_id`, `text`, `id_com`, `data`, `moderation`) VALUES (:position, :rev, NULL, :discription, :id_com, :date, :moderation)");
      $ret    = $query->execute($req);
    } catch (PDOException $e) {
      exit('Ошибка: ' . $e->getMessage());
    }

    if($ret)
      echo 'ok';
    else 
      echo 'error';
  } 

# ПУбликация коменнтариев
if($_GET['func'] == 'create_comment')
{
  # Проверяем капчу
  if ( !captcha($_POST['id'], $_POST['key'], $_POST["g-recaptcha-response"]) )
    exit('Вы не указали карчу.');

  # Проверяем наличие типа
  if ( !in_array($_POST['type'], ['hr', 'rating']) )
    exit('Что-то пошло не так...');

  $req = array(
    'id'           => (int) $_POST['id'],
    'fio'          => trim($_POST['fio']),
    'discription'  => trim($_POST['comment']),
    'data'         => time(),
    'type'         => $_POST['type']
  );

  foreach ($req as $value)
    if(iconv_strlen($value) == 0) exit('Пожалуйста заполните все поля.');

  try{
    $query  = $PDO->prepare("INSERT INTO `comment`(`fio`, `text`, `review`, `moderation`, `data`, `type`) VALUES (:fio, :discription, :id, 0, :data, :type)");
    $ret    = $query->execute($req);

    if($ret) echo 'ok';
  }catch(PDOException $e){
    exit('Произошла ошибка:'.$e->getMassage());
  }
}

if($_GET['func'] == 'new_requests'){

  //Выкидываем хитрых
  if( !captcha($_POST['id'],  $_POST['key'], $_POST["g-recaptcha-response"]))
    exit('Вы не указали карчу.');

  if($_POST['fio'] == '' or $_POST['phone'] == '')
     exit('Пожалуйста заполните все поля.');

   $id    = $_POST['id'];
   $query = $PDO->query("SELECT `email`, `email_hr` FROM `company` WHERE `id`= $id LIMIT 1");
   $row   = $query->fetch();

  if($query->rowCount()){

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  
    if ( $_POST['type'] == 'hr' ) {
      $email = $row['email_hr']; //Мыло компании 
      $subject = 'Новая заявка с сайта '.$_SERVER['HTTP_HOST']. ' HR';

      $message = '<html>
        <head>
          <title>Пользователь хочет узнать о текущих вакансиях '.$_SERVER['HTTP_HOST'].'</title>
        </head>
        <body>
          <h1 style="margin-botto:20px;">Пользователь хочет узнать о текущих вакансиях '.$_SERVER['HTTP_HOST'].'</h1>
          <div>Пользователь сайта '.$_SERVER['HTTP_HOST'].' хочет узнать о вакансиях вашей компании.</div>
          </br>
          <div style="margin-bottom:10px;"><b>Данные:</b></div>
          </br>
          <div><b>Ф.И.О: </b>'.$_POST['fio'].'</div>
          </br>
          <div><b>Телефон: </b>'.$_POST['phone'].'</div>

          <div style="margin-top: 20px;"><b>*</b> Сообщение отправлено автоматически, на него отвечать не нужно.</div>
        </body>
        </html>';

      $headers .= 'From: Новая заявка <info@rating-remont.moscow> HR';
    }

    $to = $email;           // обратите внимание на запятую
   
    if(mail($to, $subject, $message,  $headers))
      echo true;
    else
      exit('Что-то пошло не так...');

  }else{
   exit('Что-то пошло не так...');
  }
}

?>
