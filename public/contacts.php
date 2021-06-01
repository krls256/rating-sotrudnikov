<?php

use app\Http\Controllers\User\ContactsPageController;
use app\Repositories\Base\BaseSettingsRepository;
use helperClasses\Request;

require_once "function.php";

$settingsRepo = new BaseSettingsRepository();
$set = $settingsRepo->getSetting();

$request = new Request();
$controller = new ContactsPageController();

$controllerData = $controller->index($request);
$companiesSide = $controllerData['companies'];

?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?=$set['contact_title']?></title>
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="<?=$set['contact_des']?>">
    
    <meta name="yandex-verification" content="<?=$set['ya_code']?>" />

	  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css?<?=time()?>">
    <link rel="stylesheet" href="/css/formstyler.css">
    <script src="js/jquery.js"></script>
  </head>
  <body>
  <div class="wrapper">
    <?php mv_header($set['header']); ?>
    <div class="content">
      <div class="content__item-left">
        <div class="snippet">
          <div class="home_articls">
            <div class="home_articls__text">
              <h3>О нас</h3>
              <span>Наш сайт создан для быстрого и честного поиска компании для работы. На данном ресурсе собрана информация и отзывы сотрудников о ремонтных компаниях Москвы и МО.</span>
              <span><b><i style="color:red;">* </i>Внимание </b> Используя наш ресурс вы автоматически соглашаетесь с правилами и условиями испльзования нашего ресурса.</span>
              <span><a href="/upload/pologenie_sayta.doc">Ознакомиться с положением вы можете по данной ссылке <?=$_SERVER['HTTP_HOST']?></a></span>
              <h3>Связь с нами</h3>
              <span>Все вопросы или претензии вы может написать нам на нашу электронную почту.</span>
              <span><b>Email: </b> info@<?=$_SERVER['HTTP_HOST']?></span>
            </div>
          </div>
        </div>
        <div class="snippet snippet-title">
          <h3>Последние отзывы сотрудников</h3>
        </div>
        <div class="last-review">
        <?php $query = $PDO->query("SELECT * FROM `review` WHERE `review_pluses` != '' and `review_minuses` != '' ORDER BY review_date DESC LIMIT 4");
          while($row = $query->fetch()){

            $idCom = $row['company_id'];
            $nameCompany = $PDO->query("SELECT `name`, `url` FROM `company` WHERE `id` = $idCom LIMIT 1");
            $name = $nameCompany->fetch();

            ?>
             <div class="last-review__item">
               <div class="last-review__header">
                 <span><b><?=$row['reviewer_position']?></b> об <a
			                 href="/otzyvy-sotrudnikov-<?=$name['url']?>#rew_block">"<?=$name['name']?>"</a></span>
               </div>
               <div class="last-review__body"><?=
	               $func->crop(htmlspecialchars_decode($row['review_pluses'].$row['review_minuses']), 350);
               ?></div>
               <div class="last-review__footer"><span><?php
                       $date = \Carbon\Carbon::parse($row['review_date']);
                       $date->setTimezone('+3');
                       echo $date->isoFormat('YYYY-MM-DD');
                       ?></span><a href="/otzyvy-sotrudnikov-<?=$name['url']?>#rew_block">Читать</a></div>
             </div>
          <?php } ?>
        </div>
      </div>
      <?php include 'modules/right.php'; ?>
    </div>
    <?php include 'modules/footer.php'; ?>
  </div>
  <?php include 'modules/scripts.php'; ?>
  </body>
</html>
