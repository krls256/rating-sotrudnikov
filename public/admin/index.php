<?php
include "function.php"; //Управляющий файл

$set = setting($PDO);
?>

<!DOCTYPE html>
<html lang="ru-RU" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Админ панель</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>
<body>
<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
	<div class="content">
		<div class="block">
			<h1 class="block__title">Настройки</h1>
            <div class="login__error"></div>
			<div class="setting">
				<form class="edit-index" action="" method="post">
					<span class="line_title">Главная</span>
                    <input type="hidden" name="id" value="1">
					<p>
						<span>Title</span>
						<input type="text" value="<?= $set['title'] ?>" name="title">
					</p>
					<p>
						<span>Description</span>
						<textarea name="description" cols="30" rows="5"><?= $set['description'] ?></textarea>
					</p>
					<p>
						<span>H1</span>
						<input type="text" value="<?= $set['h1'] ?>" name="h1">
					</p>
					<p>
						<span>Текст под H1</span>
						<textarea name="index_text" cols="30" rows="5"><?= $set['index_text'] ?></textarea>
					</p>
					<span class="line_title">Все отзывы</span>
					<p>
						<span>Title</span>
						<input type="text" value="<?= $set['all_rev_title'] ?>" name="all_rev_title">
					</p>
					<p>
						<span>Description</span>
						<textarea name="all_rev_des" cols="30" rows="5"><?= $set['all_rev_des'] ?></textarea>
					</p>
					<p>
						<span>H1</span>
						<input type="text" value="<?= $set['all_rev_h1'] ?>" name="all_rev_h1">
					</p>
					<p>
						<span>Текст под H1</span>
						<textarea name="all_rev_text" cols="30" rows="5"><?= $set['all_rev_text'] ?></textarea>
					</p>
					<span class="line_title">Контакты</span>
					<p>
						<span>Title</span>
						<input type="text" name="contact_title" value="<?= $set['contact_title'] ?>">
					</p>
					<p>
						<span>Description</span>
						<textarea name="contact_des" cols="30" rows="5"><?= $set['contact_des'] ?></textarea>
					</p>
					<span class="line_title">Общее</span>
					<p>
						<span>Модерация</span>
						<select class="width-auto" id="moderation" name="moderation">
							<option value="0" <? echo $set['moderation'] == 0 ? 'selected' : ''; ?> >Включена</option>
							<option value="1" <? echo $set['moderation'] == 1 ? 'selected' : ''; ?>>Отключена</option>
						</select>
					</p>
					<p>
						<span>Текст в шапке</span>
						<input type="text" value="<?= $set['header'] ?>" name="header">
					</p>
					<p>
						<span>ID яндекс метрики</span>
						<input type="text" value="<?= $set['ya_metriks'] ?>" name="ya_metriks">
					</p>
					<p>
						<span>ID google аналитики</span>
						<input type="text" value="<?= $set['google_metriks'] ?>" name="google_metriks">
					</p>
					<div class="index_log" id="index_log"></div>
					<input class="submit index_seve" style="margin:15px 0 0;" type="submit" value="Сохранить">
				</form>
			</div>
		</div>
		<div class="block">
			<h1 class="block__title">Советы</h1>
			<div class="review-edit">
                <?php $QuerAdvice = $PDO->query("SELECT * FROM `advice`"); ?>
				<form method="" action="" class="advice" onsubmit="return false;">
					<div class="create__item">
                        <?php $i = 1;
                        while ($row = $QuerAdvice->fetch()) { ?>
							<p>
								<span>Совет №<?= $i ?></span>
								<textarea style="width: 600px;" name="advice-<?= $i ?>" <?php echo ($i == 1 or
                                    $i == 2) ? "data-check='true'" : ''; ?>><?= $row['text'] ?></textarea>
							</p>
                            <?php $i++;
                        } ?>
						<input type="submit" value="Сохранить" class="submit" style="margin-top: 15px;">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="/js/formstyler.js"></script>
<script src="/js/admin.js?<?= time() ?>"></script>
</body>
</html>
