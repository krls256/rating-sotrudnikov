<?php
  require_once "function.php";

  $show = 10;
  $set  = setting($PDO);

  //Количество записей
	// TODO: add is publish check
  $count = $PDO->query("SELECT * FROM `review` WHERE `review_pluses` != '' and `review_minuses` != '' and `is_published` = 1");
  $total = $count->rowCount();

  //Номера страниц
  $page = $_GET['page'] ?? '';
  if(!is_numeric($page) or $page < 1) $page = 1;

  //Количество страниц
  $pages = $total/$show;
  $pages = ceil($pages);
  $pages++;

  if ($page>$pages) $page = 1;
  if (!isset($list)) $list = 0;

  $list=--$page*$show;

  $sqlDev = ( !empty($_SESSION['id']) and $_SESSION['id'] != '' )?'':'and c.dev IS NULL';

  $commentQuery = $PDO->query("SELECT 
                                    r.id, 
                                    c.dev, 
                                    r.reviewer_position, 
                                    r.is_positive, 
                                    r.review_pluses,
       								r.review_minuses,
                                    r.company_id, 
                                    r.review_date,
                                    r.is_published
                                FROM 
                                  `review` r 
                                LEFT OUTER JOIN `company` c ON 
                                  r.company_id = c.id 
                                WHERE 
                                  r.review_pluses != '' and r.review_minuses != '' $sqlDev and r.is_published = 1
                                ORDER BY r.review_date DESC LIMIT $show OFFSET $list");

  $сurrent = $page+1;  //Текущая страница
  $start = $сurrent-3; //перед текущей
  $end = $сurrent+3;   //После текущей

  //Форматирование description
  $dp = $page+1;
  $getDes = $set['all_rev_des'];

  if($page+1!=1){
    $echoPage = "— страница " . $dp;
    $echoDes = sprintf($getDes, $echoPage);
  } else {
    $echoDes = str_replace(' %s', "", $getDes);
  }
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
  <head>
    <title><?php echo $set['all_rev_title'];?></title>
    <meta name="description" content="<?=$echoDes?>">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

	  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css?<?=time()?>">
    <link rel="stylesheet" href="/css/formstyler.css">
	  <link rel="canonical" href="https://<?=$_SERVER['HTTP_HOST']?>/all-review"/>
  	<?php
          if ($page+1==1) {
              echo '<link rel="next" href="https://'.$_SERVER['HTTP_HOST'].'/all-review?page=2" />'; 		 	  //следующая
          }else if($page+1 == $pages-1){
  			echo '<link rel="prev" href="https://'.$_SERVER['HTTP_HOST'].'/all-review?page='.($page+1).'"/>';  //Назад
  		}else{
  			echo '<link rel="next" href="https://'.$_SERVER['HTTP_HOST'].'/all-review?page='.($page+2).'" />'; //следующая
  			echo '<link rel="prev" href="https://'.$_SERVER['HTTP_HOST'].'/all-review?page='.($page).'"/>';    //Назад
  		}
      ?>

    <script src="js/jquery.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <?php mv_header($set['header']); ?>
      <div class="content">
        <div class="content__item-left">
          <div class="snippet">
            <h1><?php echo $set['all_rev_h1'];?></h1>
            <p class="index__text"><?php echo $set['all_rev_text'];?></p>
          </div>
          <?php
            if($commentQuery->rowCount() > 0){
              while($commentRow = $commentQuery->fetch()){
                $CompanyID  = $commentRow['company_id'];
                $commentID  = $commentRow['id'];

                /*Нужно получить название компании
                  Можно получить из первого запроса,
                  пишу на будущее для раздела "все отзывы"
                */
                $companyQuery = $PDO->query("SELECT * FROM `company` WHERE `id`=$CompanyID LIMIT 1");
                $companyRow   = $companyQuery->fetch();
            ?>
              <div class="snippet review">
                <div class="review__header">
                  <div class="review__user">
                    <b><?=$commentRow['reviewer_position']?></b> <span>о компании "<a
				                  href="/otzyvy-sotrudnikov-<?=$companyRow['url'];?>/"><?=$companyRow['name']?></a>"</span>
                  </div>
                  <div class="review__like <?php echo $commentRow['is_positive']==1?'positive':'negativ'; ?>">
                    <i></i> <?php echo $commentRow['is_positive']==1?'Рекомендую':'Не рекомендую'; ?>
                  </div>
                </div>
                <div class="review__text">
                  <?=htmlspecialchars_decode($commentRow['review_pluses'] . $commentRow['review_minuses']);?>
                </div>
                <div class="review__footer all-review__footer">
                  <span><?php
                      $date = \Carbon\Carbon::parse($commentRow['review_date']);
                      $date->setTimezone('+3');
                      echo $date->isoFormat('YYYY-MM-DD');
                      ?></span>
                  <?php $comm = $PDO->query("SELECT * FROM `comment` WHERE `review` = $commentID and `moderation` = 1")
                  ; ?>
                  <span><?=$comm->rowCount()?></span>
                  <a href="/otzyvy-sotrudnikov-<?=$companyRow['url']?>/" class="company__bottom-green">Все отзывы о компании</a>
                </div>
              </div>
            <?php } ?>
            <div class="page_nav">
              <?php
                 if ($page>=1) {
                    echo '<a href="/all-review?page=1" class="oneLink"></a>'; //На первую
                    echo '<a href="/all-review?page='.$page.'" class="nav-prev"></a>'; //Назад
                  }

              $сurrent = $page+1; //Текущая страница
              $start = $сurrent-3; //перед текущей
              $end = $сurrent+3; //После текущей

              for ($j = 1; $j < $pages; $j++) {
                if ($j>=$start && $j<=$end) {

                  if ($j==($page+1))
                    echo '<a href="all-review?page=' . $j . '" class="active">' . $j . '</a>';
                  else
                    echo '<a href="all-review?page=' . $j . '">' . $j . '</a>';
                }
              }

              if ($j>$page && ($page+2)<$j) {
                  echo '<a href="all-review?page=' . ($page+2) . '" class="nav-next"></a>';
                  echo '<a href="all-review?page=' . ($j-1) . '" class="lastLimk"></a>';
              }
              ?></div><?php
          }else{
              ?>
              <div class="snippet">
                <span class="noReview">У компании нет отзывов! Оставь отзыв первым <i></i></span>
              </div>
              <?php
            } ?>
        </div>
        <?php include 'modules/right.php'; ?>
      </div>
      <?php include 'modules/footer.php'; ?>
    </div>
    <?php include 'modules/scripts.php';?>
  </body>
</html>
