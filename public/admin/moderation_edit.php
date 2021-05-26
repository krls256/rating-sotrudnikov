<?php

use app\Http\Controllers\ReviewsAdminController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;
include 'function.php';


$repository = new ReviewRestRepository();
$controller = new ReviewsAdminController($repository);
$data = $controller->edit(Request::capture()->all());
$row = $data['review'];
$companies = $data['companies'];
$is_published = $row['is_published']; //Опубликованый или нет. 0 - на мадерации, 1 - опубликован
?><!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Редактирование отзыва сотрудника</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>
<body>
<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
	<div class="content">
		<div class="block">
			<div class="block__title">Редактирование отзыва сотрудника</div>
			<div class="login__error"></div>
            <?php include_view("includes/adminMessageBar.php"); ?>
			<form class="review-edit review-hr-edit" action="/admin/review/update.php" method="post">
				<input type="hidden" name="id" value="<?= $row['id'] ?>">
				<p>
					<label for="reviewer_name" class="d-block">Имя пользователя</label>
					<input type="text" name="reviewer_name" value="<?php echo $row['reviewer_name'] ?>">
				</p>
				<p>
					<label for="reviewer_position" class="d-block">Должность</label>
					<input type="text" name="reviewer_position"  value="<?php echo $row['reviewer_position'] ?>">
				</p>
				<p>
					<label for="review_date" class="d-block">Дата публикации</label>
					<input type="text" name="review_date" required value="<?= $row['UserDate'] ?>">
				</p>
				<p>
					<label for="review_pluses" class="d-block">Плюсы</label>
					<textarea name="review_pluses" rows="8" cols="80"><?= ($row['review_pluses']) ?></textarea>
				</p>
				<p>
					<label for="review_minuses" class="d-block">Минусы</label>
					<textarea name="review_minuses" rows="8" cols="80"><?= ($row['review_minuses']) ?></textarea>
				</p>
				<p>
					<label for="company_id" class="d-block">Компания</label>
					<select name="company_id" id="company_id">
						<?php
							foreach ($companies as $company) {
								$value = $company->id;
								$text = $company->name;
								$selected = $row->company_id === $company->id ? "selected" : "";
								echo "<option value='$value' $selected>$text</option>";
							}
						?>
					</select>
				</p>
				<p>
					<input type="hidden" value="0" name="is_positive">
					<input type="checkbox" value="1" name="is_positive" id="is_positive" <?php if
					($row['is_positive']) echo 'checked'; ?>>
					<label for="is_positive">Положительный</label>

				</p>
				<p>
					<input type="hidden" value="0" name="is_published">
					<input type="checkbox" value="1" name="is_published" id="is_published" <?php if
                    ($row['is_published']) echo 'checked'; ?>>
					<label for="is_published">Опубликован</label>

				</p>
				<div>
					<input class="submit" style="margin:20px 0px; display:inline-block;" type="submit" value="Обновить">
					<button data-id="<?= $row['id'] ?>" class="submit hr-rev-dal" type="button">Удалить</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="/js/formstyler.js"></script>
<script src="/js/admin.js?<?= time() ?>"></script>
</body>
</html>
