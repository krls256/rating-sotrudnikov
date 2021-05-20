<?php
  require_once "function.php";

  $set = setting($PDO);

  if( !empty($_SESSION['id']) != '') {
    $dev = true;
    $sqlDev = '';
  } else{
    $dev = false;
    $sqlDev = 'WHERE `dev` IS NULL';
  }

  $com = $PDO->query("SELECT *,
                            (select count(*) from `review` where `company_id` = company.id and `is_published` = 1) as `sort`,
                            if(`position`, `position`, 9999) as 'pos'
                          FROM
                            `company` $sqlDev
                          ORDER BY `pos` ASC, `sort` DESC");
  $exploded = explode('.', $_SERVER['HTTP_HOST']);
  $sub = array_shift($exploded);
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <title><?php echo $set['title'];?></title>
    <meta name="description" content="<?php echo $set['description'];?>">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="canonical" href="https://<?=$_SERVER['HTTP_HOST']?>/"/>

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Рейтинг ремонтных компаний">
    <meta property="og:title" content="<?php echo $set['title'];?>" />
    <meta property="og:description" content="<?php echo $set['description'];?>" />
    <meta property="og:url" content="https://<?=$_SERVER['HTTP_HOST']?>/" />
    <meta property="og:image" content="https://<?=$_SERVER['HTTP_HOST']?>/images/logo.png" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css?v=0.0.1">
    <link rel="stylesheet" href="/css/formstyler.css?v=0.0.1">
    <script src="/js/jquery.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <?php mv_header($set['header']); ?>
      <div class="content">
        <div class="content__item-left">
          <div class="snippet">
            <h1><?php echo $set['h1'];?></h1>
            <p class="index__text"><?php echo $set['index_text'];?></p>
          </div>
          <div class="snippet">
            <div class="snippet__list">
              <div class="string">
                <span>№</span>
                <span>Логотип</span>
                <span>Компания</span>
                <span>Голосовать</span>
                <span>Отзывов</span>
                <span>Заявки</span>
              </div>
              <?php
                $i = 1;
                while ($row = $com->fetch()) {
                  $id = $row['id'];
                  $key = $func->hash($id);

                  $positiveReviewQuery = $PDO->query(
                                                "SELECT
                                                    count(*) as 'pos',
                                                    (SELECT count(*) FROM `review` WHERE `company_id` = $id and `is_positive`= 0 and `is_published` = 1) as 'neg'
                                                FROM
                                                  `review`
                                                WHERE
                                                  `company_id` = $id and `is_positive`= 1 and `is_published` = 1"
                                              );
                  $positiveReview = $positiveReviewQuery->fetch();
                  ?>
                  <div class="string">
                    <a href="/otzyvy-sotrudnikov-<?=$row['url']?>/" class="string__namber"><?=$i?></a>
                    <a href="/otzyvy-sotrudnikov-<?=$row['url']?>/" class="string__img"><img src="<?=$row['logo']?>" alt="<?=$row['name']?>"/></a>
                    <span class="string__name"><a href="/otzyvy-sotrudnikov-<?=$row['url']?>/" title="Информация о компании"><?=$row['name']?></a></span>
                    <span class="string__like">
                      <a href="/otzyvy-sotrudnikov-<?=$row['url']?>/1/positive#rew_block" title="Только положительные отзывы"><span class="positive"><i></i><?=$positiveReview['pos']?></span></a>
                      <a href="/otzyvy-sotrudnikov-<?=$row['url']?>/1/negative#rew_block" title="Только отрицательные отзывы"><span class="negativ"><i></i><?=$positiveReview['neg']?></span></a>
                    </span>
                    <a href="/otzyvy-sotrudnikov-<?=$row['url']?>/#rew_block" title="Читать все отзывы">
                      <span class="string__total"><i></i><?=trim($positiveReview['pos'] + $positiveReview['neg'])?></span>
                    </a>
                    <span class="string__req">
                      <a href="#" class="request_modal" data-id="<?=$id?>" data-key="<?=$key?>" data-type="request" data-val="hr" title="Оставить заявку"></a>
                    </span>
                  </div>
                  <?php
                  $i++;
                }
              ?>
            </div>
          </div>
          <div class="snippet snippet-title">
            <h3>Последние отзывы сотрудников</h3>
          </div>
          <div class="last-review">
          <?php $query = $PDO->query("SELECT * FROM `review` WHERE `review_pluses` != '' and `review_minuses` != '' and `is_published` = 1 ORDER BY review_date DESC LIMIT 4");
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
                 <div class="last-review__body"><?=$func->crop(htmlspecialchars_decode($row['review_pluses'].$row['review_pluses']), 350);
                 ?></div>
                 <div class="last-review__footer"><span><?php
                     $date = \Carbon\Carbon::parse($row['review_date']);
                     $date->setTimezone('+3');
                     echo $date->isoFormat('YYYY-MM-DD');
                     ?></span><a href="/otzyvy-sotrudnikov-<?=$name['url']?>#rew_block">Читать</a></div>
               </div>
            <?php } ?>
          </div>
          <div class="snippet">
            <div class="home_articls">
              <div class="worker-home"></div>
              <div class="home_articls__text">
                <h2>Поиск работы с помощью отзыва сотрудников</h2>
                <span>Выбор ремонтной компании для трудоустройства – непростая задача, требующая обдуманного подхода. Выбор зависит от множества факторов, включая опыт сотрудников, репутацию фирмы на рынке ремонтных услуг, стабильность, оплата труда и многое другое.</span>
                <h3>Особенности и преимущества</h3>
                <span>Никто не способен знать компанию и все её нюансы лучше, чем те, кто видит её изнутри. Сотрудники фирмы всегда являются бесценным источником информации, ведь они наблюдают не только результат, но и процесс его достижения.</span>
                <span>Именно сотрудники той или иной ремонтной фирмы могут дать по-настоящему полную, а потому достоверную информацию, которая окажется решающей для многих людей, планирующих трудоустройство в ту или иную компанию.</span>
                <span>Специально для вас мы подготовили рейтинг ремонтных компаний, основанный на мнении и отзывах реальных сотрудников этих фирм. Подобный рейтинг дарит массу очевидных преимуществ:</span>
                <ul>
                  <li>экономия времени (вам больше не нужно тратить уйму времени на поиск рейтингов и отзывов на разных независимых сайтах);</li>
                  <li>получение полных и достоверных сведений о фирме (основанных на мнении людей как снаружи, так и изнутри компании);</li>
                  <li>большое количество информации о разных компаниях, собранной в одном месте</li>
                  <li>возможность сравнения различных фирм для принятия верного решения.</li>
                </ul>
                <span>Кроме того, отзывы помогают выбрать не только конкретную организацию, но и сравнить её с другими.</span>
              </div>
            </div>
            <div class="home_articls">
              <div class="home_rating"></div>
              <div class="home_articls__text">
                <h3>Что мы предлагаем?</h3>
                <span>Рейтинг – это не просто список из 10 самых известных и зарекомендовавших себя фирм. Пользователи могут увидеть номер в рейтинге, логотип организации, название и рейтинг в голосовании (на сайте предусмотрена возможность поставить как положительную, так и отрицательную оценку). Чтобы предоставить потенциальным работникам достоверные данные для выбора подходящей им компании для работы, наши эксперты собрали максимальное количество сведений, которые прошли строгую проверку и анализ. В результате нам удалось представить всю информацию в лаконичном и удобном формате.</span>
                <span>Мы тщательно изучили и систематизировали полученные сведения, сопоставив их с другими данными о компаниях из авторитетных источников. В результате нам удалось создать честный рейтинг, который будет полезен специалистам, ищущим работу и выполняющим:</span>
                <ul>
                  <li>ремонт под ключ;</li>
                  <li>частичный или несложный мелкий ремонт жилых/нежилых объектов;</li>
                  <li>любой другой вид профессионального ремонта.</li>
                </ul>
                <span>В рейтинге представлены отзывы на каждую фирму, с которыми вы можете подробнее ознакомиться, нажав на иконку отзывов напротив соответствующей компании. На сайте представлено оптимальное количество отзывов, чтобы потенциальные работники смогли убедиться в честности и независимости представленной информации.</span>
              </div>
            </div>
          </div>
          <div class="snippet">
            <div class="home_articls">
              <div class="home_articls__text">
                <h2>Дополнительные опции</h2>
                <span>Ознакомившись с рейтингом и отзывами, можно получить более подробную информацию о каждой компании, кликнув на неё. Вы также можете оставить заявку на работу, оставив своё имя и контактный телефон.</span>
                <span>Извлекайте максимальную пользу из нашего ТОПа ремонтных компаний, работающих по Москве и Московской области. Выбирайте только лучших работодателей в сфере ремонта, доверяя фирмам с хорошей репутацией как среди клиентов, так и среди сотрудников! А мы поможем сделать ваш выбор проще и приятнее.</span>
              </div>
            </div>
          </div>
        </div>
        <?php include 'modules/right.php'; ?>
      </div>
      <?php include 'modules/footer.php'; ?>
    </div>
    <?php include 'modules/scripts.php'; ?>
  </body>
</html>
