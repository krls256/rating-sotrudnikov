<?php
  //количество пользовательских отзывов
  $CRUQ = $PDO->prepare("SELECT count(*) as count FROM `review` WHERE `is_published` = '0'");
  $CRUQ->execute();
  $CRU  = $CRUQ->fetch();
//  dd($CRU);
?>
<div class="menu">
  <a href="/admin/"><div class="menu__logo">RATING <span>SOTRUDNIKOV</span></div></a>
  <ul class="menu__link">
    <a href="/admin/create-company"><li>Добавить компанию</li></a>
    <a href="/admin/page-edit-com"><li>Ред. компаний</li></a>
    <a href="/admin/create-review"><li>Добавить отзыв</li></a>
    <?php if(($set['moderation'] ?? null) == 0) { ?><li class="harmonic active">
      <div>Модирация отзывов</div>
      <ul>
        <a href="/admin/moderation?type=user"><li>Пользователи<span><?=$CRU['count']?></span></li></a>
      </ul>
    </li>
    <?php } ?>
  </ul>
  <ul class="menu__link">
    <a href="/"><li>На главную</li></a>
    <a href="/admin/exit"><li>Выйти</li></a>
  </ul>
</div>
