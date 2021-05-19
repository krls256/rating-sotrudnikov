<?php
  include "function.php"; //подключаем файл обработчик

  $id_filter  = (int) ($_GET['id'] ?? null); //Id компании для фильтрации
  $page       = (int) ($_GET['page'] ?? null); //Номера страниц
  $show       = 20;

  if( !is_numeric( $page ) or $page < 1 ) $page = 1;

  //проверяем существует ли фильтр
  if( empty( $_GET['id'] ) or $id_filter == '' or $id_filter == 0){
  	$sql_filter = '';
    $id_filter  = '';
  }else{
    $sql_filter = 'and `id_com` ='.$id_filter;
    $id_page    = '&id='.$id_filter;
  }

  $totalQ  = $PDO->prepare( "SELECT count( CASE WHEN `is_positive`=0 THEN 1 ELSE NULL END ) as `neg`, count( CASE WHEN `is_positive`=1 THEN 1 ELSE NULL END ) as `pos`FROM `review` WHERE `is_published` = 0  $sql_filter");
  $totalQ->execute();

  //Количество страниц
  $total  = $totalQ->fetch();
  $pages  = max($total['pos'], $total['neg'])/$show;
  $pages  = ceil($pages);
  
  $pages++;

  if ($page>$pages) 
    $page = 1;

  if (!isset($list)) 
    $list = 0;

  $list=--$page*$show;

  $rev1 = $PDO->prepare("SELECT * FROM `review` WHERE `is_published` = 0 and `is_positive` = 1 $sql_filter ORDER BY `review_date` DESC LIMIT $show OFFSET $list");
  $rev1->execute();

  //получаем положительные отзывы
  $rev2 = $PDO->prepare("SELECT * FROM `review` WHERE `is_published` = 0 and `is_positive` = 0 $sql_filter ORDER BY `review_date` DESC LIMIT $show OFFSET $list");
  $rev2->execute();
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>Модерация отзывов пользователей</title>
   <link rel="stylesheet" href="/css/admin.css?<?=time()?>">
   <link rel="stylesheet" href="/css/formstyler.css">
   <link rel="stylesheet" href="/css/formstyler.theme.css">
   <script type="text/javascript" src="/js/jquery.js"></script>
 </head>
 <body>
  <div class="page__layout">
    <?php include 'modules/menu.php' ?>
    <div class="content">

      <!--Верхняя панель-->
      <div class="block mod_title" style="padding:15px; width:99.2%">
        <h2>Модерация отзывов пользователей</h2>
        <select class="filter_moderation" id="filter_moderation">
          <option value="0">Все</option>
          <?php
          $queryCompany = $PDO->query("SELECT `id`, `name` FROM `company`");

          while($row = $queryCompany->fetch()){
            $com_id = $row['id'];
            global $type;

            $countRewiev = $PDO->prepare("SELECT count(*) FROM `review` WHERE `company_id` = :id and `is_published` = 0");
            $countRewiev->execute(array('id' => $com_id));

          ?>
            <option value="<?=$row['id']?>" <?=$com_id==$id_filter?'selected':'';?>><?=$row['name']?> (<?=$countRewiev->fetch()[0]?>)</option>
          <?php } ?>

        </select>
      </div>

      <?php if( $rev1->rowCount() <= 0 and $rev2->rowCount() <= 0){ ?>
            <div class="block" style="color: #828282; text-align: center; font-size:21px; font-weight: bold;">Отзывов пока нет!</div>
      <?php } ?>

      <div class="revFlex">
        <!-- Блок отзывов -->
        <!--Положительные отзывы-->
        <div class="revFlex__item">
          <?php while($row = $rev1->fetch()){ ?>
                  <div class="block">
                    <div class="header-mod">
                      <div class="header-mod__user"><?=$row['reviewer_name']?> об <span><?=infoCompany($row['company_id'],
			                      $PDO)->name?></span></div>
                      <div class="header-mod__reveiw--<? echo $row['is_positive']==1?'green':'red';?>"><? echo
	                      $row['is_positive']==1?'Положительный':'Отрицательный';?></div>
                    </div>
                    <div class="text-review">
	                    <div class="header-mod__user">Плюсы</div>
                        <?php echo htmlspecialchars_decode($row['review_pluses']); ?>
	                    <div class="header-mod__user">Минусы</div>
                        <?php echo htmlspecialchars_decode($row['review_minuses']); ?>
                    </div>
                    <div class="review-bottom">
                      <span><?php
	                        $date = \Carbon\Carbon::parse($row['review_date']);
	                        $date->setTimezone('+3');
	                        echo $date->isoFormat('YYYY-MM-DD');
	                      ?></span>
                      <a href="moderation_edit?id=<?=$row['id']?>" class="revive-edit"></a>
                      <buttom class="submit submit--green" style="margin-left:15px;" data-id="<?=$row['id']?>" data-key="<?=substr(md5($row['id']), 0, 8);?>" data-type="1">Опубликовать</buttom>
                      <buttom class="submit submit--red" data-id="<?=$row['id']?>" data-key="<?=substr(md5($row['id']), 0, 8);?>" data-type="1">Отключить</buttom>
                    </div>
                  </div>
                <?php } ?>
                </div>

                <!--отрицательные отзывы-->
                <div class="revFlex__item">
                <?php while($row = $rev2->fetch()){?>
                    <div class="block">
                      <div class="header-mod">
                        <div class="header-mod__user"><?=$row['reviewer_name']?> об <span><?=infoCompany($row['company_id'], $PDO)->name?></span></div>
                        <div class="header-mod__reveiw--<? echo $row['is_positive']==1?'green':'red';?>"><? echo
	                        $row['is_positive']==1?'Положительный':'Отрицательный';?></div>
                      </div>
                      <div class="text-review">
	                      <div class="header-mod__user">Плюсы</div>
                          <?php echo htmlspecialchars_decode($row['review_pluses']); ?>
	                      <div class="header-mod__user">Минусы</div>
                          <?php echo htmlspecialchars_decode($row['review_minuses']); ?>
                      </div>
                      <div class="review-bottom">
                        <span><?php
                            $date = \Carbon\Carbon::parse($row['review_date']);
                            $date->setTimezone('+3');
                            echo $date->isoFormat('YYYY-MM-DD');
                            ?></span>
                        <a href="moderation_edit?id=<?=$row['id']?>" class="revive-edit"></a>
                        <buttom class="submit submit--green" data-id="<?=$row['id']?>" data-key="<?=substr(md5($row['id']), 0, 8);?>" data-type="1" style="margin-left:15px;">Опубликовать</buttom>
                        <buttom class="submit submit--red" data-id="<?=$row['id']?>" data-key="<?=substr(md5($row['id']), 0, 8);?>" data-type="1">Отключить</buttom>
                      </div>
                    </div>
                  <?php } ?>
                  </div>
      </div>
      <?php if( ( $pages-1 ) != 1 and ( $type == 'flamp' or  $type == 'yell' or $type == 'user') ){?>
        <div class="page_nav"><?php
          if( $page>=1 ) {
            echo '<a href="moderation?type='.$type.$id_page.'" class="oneLink"></a>'; //На первую
            echo '<a href="moderation?type='.$type.'&page='.$page.$id_page.'" class="nav-prev"></a>'; //Назад
          }

          $сurrent = $page+1; //Текущая страница
          $start = $сurrent-3; //перед текущей
          $end = $сurrent+3; //После текущей

          //Навигация по страницам
          for ($j = 1; $j < $pages; $j++) {
              if ( $j >= $start && $j <= $end) {

                if( $j == ( $page+1 ) )
                  echo '<a href="moderation?type='.$type.'&page='.$j.$id_page.'" class="active">' . $j . '</a>';
                else
                  echo '<a href="moderation?type='.$type.'&page='.$j.$id_page.'">' . $j . '</a>';
              }
            }

            if( $j > $page && ( $page+2 ) < $j) {
              echo '<a href="moderation?type='.$type.'&page=' . ($page+2) . $id_page.'" class="nav-next"></a>';
              echo '<a href="moderation?type='.$type.'&page=' . ($j-1) . $id_page.'" class="lastLimk"></a>';
            }?>
          </div>
        <?php } ?>
    </div>
  </div>
  <script src="/js/formstyler.js"></script>
  <script src="/js/admin.js?<?=time()?>"></script>
 </body>
</html>
