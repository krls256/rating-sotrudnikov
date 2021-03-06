<?php include "function.php"; //Управляющий файл?>

<!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Парсер YELL.RU</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>
<body>
<div class="page__layout">
    <?php include_view('/includes/admin/adminMenu.php'); ?>
	<div class="content">
		<div class="block">
			<h1 class="block__title">Парсер <a href="https://yell.ru">YELL.RU</a></h1>
			<div class="login__error"></div>
			<div class="pars_load"></div>
			<form method="" action="" class="parser" data-type="yell" onsubmit="return false;">
				<div class="create__item">
					<p>
						<span>Название компании</span>
						<select class="width-auto" id="company" name="company">
                            <?php
                            $comName = $PDO->query("SELECT  `name`,`yell` FROM `company` WHERE yell != ''");
                            while ($row = $comName->fetch())
                            {
                                ?>
								<option value="<?= $row['yell'] ?>"><?= $row['name'] ?></option>
                            <? } ?>
						</select>
					</p>
				</div>
				<input type="submit" name="" value="Сохранить" class="submit">
			</form>
		</div>
	</div>
</div>
<script src="/js/formstyler.js"></script>
<script src="/js/admin.js?<?= time() ?>"></script>
</body>
</html>
