<?php

use app\Http\Controllers\Rest\ReviewsRestController;
use app\Repositories\Rest\ReviewRestRepository;

include 'function.php';

$repository = new ReviewRestRepository();
$controller = new ReviewsRestController($repository);
$data = $controller->create();
$row = $data['review'];
$companies = $data['companies'];

?>

<!DOCTYPE html>
<html lang="ru-RU" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>Добавить отзыв</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>
<body>
<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
	<div class="content">
		<div class="block">
			<h1 class="block__title">Добавить отзыв</h1>
            <?php include_view("includes/adminMessageBar.php"); ?>
			<div class="login__error"></div>
			<form method="POST" action="/admin/review/store.php" class="create_review_name">
				<p>
					<label for="reviewer_name" class="d-block">Имя пользователя</label>
					<input type="text" name="reviewer_name" value="<?php echo $row['reviewer_name'] ?>">
				</p>
				<p>
					<label for="reviewer_position" class="d-block">Должность</label>
					<input type="text" name="reviewer_position" value="<?php echo $row['reviewer_position'] ?>">
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
						<option value="">Компания</option>
                        <?php
                        foreach ($companies as $company)
                        {
                            $value = $company->id;
                            $text = $company->name;
                            echo "<option value='$value'>$text</option>";
                        }
                        ?>
					</select>
				</p>
				<p>
					<input type="hidden" value="0" name="is_positive">
					<input type="checkbox" value="1" name="is_positive" id="is_positive">
					<label for="is_positive">Положительный</label>

				</p>
				<p>
					<input type="hidden" value="0" name="is_published">
					<input type="checkbox" value="1" name="is_published" id="is_published">
					<label for="is_published">Опубликован</label>

				</p>
                <p>
					<input type="hidden" value="0" name="is_moderated">
					<input type="checkbox" value="1" name="is_moderated" id="is_moderated" checked>
					<label for="is_moderated">Прошел модерацию</label>

				</p>
				<div>
					<input class="submit" style="margin:20px 0px; display:inline-block;" type="submit" value="Создать">
					<button data-id="<?= $row['id'] ?>" class="submit hr-rev-dal" type="button">Удалить</button>
				</div>
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
