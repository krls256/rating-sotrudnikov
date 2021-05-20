<?php include "function.php"; //Управляющий файл?>

<!DOCTYPE html>
<html lang="ru-RU" dir="ltr">
 <head>
   <meta charset="utf-8">
   <title>Добавить отзыв</title>
   <link rel="stylesheet" href="/css/datepicker.min.css">
   <link rel="stylesheet" href="/css/admin.css?<?=time()?>">
   <link rel="stylesheet" href="/css/formstyler.css">
   <link rel="stylesheet" href="/css/formstyler.theme.css">
   <script type="text/javascript" src="/js/jquery.js"></script>
 </head>
 <body>
  <div class="page__layout">
    <?php include 'modules/menu.php' ?>
    <div class="content">
        <div class="block">
          <h1 class="block__title">Добавить отзыв</h1>
          <div class="login__error"></div>
          <form method="POST" action="" class="create_review_name">
            <p>
              <span>Компания</span>
              <select class="width-auto" id="select-castom" name="company">
                <?php
                  $company = $PDO->query("SELECT `id`, `name` FROM `company`");

                  while($row = $company->fetch()) { 
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                  }
                ?>
              </select>
            </p>
            <p>
              <span>Должность</span>
              <input type="text" name="position" data-check="true">
            </p>
            <p>
              <span>Плюсы</span>
              <textarea name="plus" data-check="true" class="edit-input__text"></textarea>
            </p>
            <p>
              <span>Минусы</span>
              <textarea name="minus" data-check="true" class="edit-input__text"></textarea>
            </p>
            <p>
              <span>Тип отзыва</span>
              <select class="width-auto" id="select-castom" name="rev">
                <option value="1">Положительный</option>
                <option value="2">Отрицательный</option>
              </select>
            </p>
            <p>
              <span>Время публикации</span>
              <input type="text" class="datepicker-here" name="time" data-timepicker="true" data-position="top left" value="<?php echo date("d.m.Y H:i");?>"/>
            </p>
            <input type="submit" value="Сохранить" class="submit" style="margin-top: 15px;"/>
          </form>
        </div>
    </div>
  </div>
  <script src="/js/formstyler.js"></script>
  <script src="/js/maps.js"></script>
  <script src="/js/datepicker.min.js"></script>
  <script src="/js/admin.js"></script>
 </body>
</html>