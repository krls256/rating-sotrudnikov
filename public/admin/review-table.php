<?php

use app\Http\Controllers\Rest\ReviewsRestController;
use app\Repositories\Rest\ReviewRestRepository;
use Illuminate\Http\Request;

require_once '../../config.php';

$repository = new ReviewRestRepository();
$controller = new ReviewsRestController($repository);
$request = Request::capture();


$controllerData = $controller->index($request->all());
$reviews = $controllerData['reviews'];
$companies = $controllerData['companies'];

?>
<!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">

<head>
	<meta charset="utf-8">
	<title>Таблица отзывов</title>
	<?php include_view('/admin/headImports.php'); ?>
</head>

<body>

	<div class="page__layout">
		<?php include_view('/admin/adminMenu.php'); ?>
		<main class="content">
			<section class="block">
                <h1>Таблица отзывов</h1>
				<div class="card card-body">
                    <?php include_view('/admin/reviews/tableControls.php',
                        [
                            'request' => $request,
                            'companies' => $companies
                        ]); ?>
				</div>
				<div class="d-inline-flex card card-body mt-3">
					<form action="" method="get">
						<button class="btn btn-info">Сбросить фильтры</button>
					</form>
				</div>
                <div class="d-flex card card-body mt-3">
					<h2>Информация о таблицах</h2>
                    <ul class="ml-4">
                        <li>После изменения формочки соответствующей строки таблицы, таблица пока ещё не меняется, но если в сообщении написано, что таблица обновлена, то она действительно обновлена</li>
                    </ul>
				</div>
				<div class="table-responsive mt-5">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Имя</th>
								<th scope="col">Должность</th>
								<th scope="col">Источник</th>
								<th scope="col">Дата отзыва</th>
								<th scope="col">Компания</th>
                                <th scope="col">Модерация</th>
								<th scope="col">Открыть</th> 
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($reviews as $index => $review) {
								$str_index = (string)$index . '-';
								$id = $review->id;
								$reviewer_name = $review->ReviewerNameNeverNull;
								$position = $review->ReviewerPositionNeverNull;
								$reviewer_position = $review->reviewer_position;
								$review_date = $review->UserDate;
								$company_name = $review->company->name;
								$source_name = $review->SourceName;
								$is_published = $review->is_published;
								$is_published_class = $is_published === 0 ? 'bg-gray-light' : '';
								$is_positive = $review->is_positive;
								$is_positive_class = $is_positive === 0 ? 'bg-danger-light' : 'bg-success-light';
                                $is_moderated = $review->is_moderated;
                                $is_moderated_class = $is_moderated === 0 ? 'not-moderated' : 'moderated';

								$review_pluses = $review->review_pluses;
								$review_minuses = $review->review_minuses;
								echo "<tr data-type='table-header' class='$is_published_class'>";
								echo "<th scope=\"row\" class='$is_positive_class'>$id</th>";
								echo "<td>$reviewer_name</td>";
								echo "<td>$position</td>";
								echo "<td>$source_name</td>";
								echo "<td>$review_date</td>";
								echo "<td>$company_name</td>";
                                echo "<td class='$is_moderated_class'></td>";
								echo "<td><span class='badge bg-info text-dark p-2' data-action='toggle-control' role='button'>Изменить</span></td>";
								echo "</tr>";
								echo "<tr data-type='table-form'><td colspan='8'>";
							?>
								<div class="d-block toggleable table-form__wrapper" data-type="form-wrapper">
									<div class="table-form__loading">
										<div class="spinner-border text-success table-form__spinner">
											<span class="sr-only">Loading...</span>
										</div>
									</div>
									<form action="/admin/review/api/update.php" method="post" class="table-ajax-form">
										<div class="alert alert-danger d-none">
										</div>
										<div class="alert alert-success d-none">
										</div>
										<div class="alert alert-warning d-none">
										</div>
										<input type="hidden" name="id" value="<?= $id ?>">
										<div class="d-flex flex-column align-items-start">
											<div class="form-group w-100">
												<label for="<?= $str_index ?>reviewer_name" class="d-block">Имя пользователя</label>
												<input type="text" id="<?= $str_index ?>reviewer_name" name="reviewer_name" class="form-control" value="<?= $reviewer_name ?>">
											</div>
											<div class="form-group w-100">
												<label for="<?= $str_index ?>reviewer_position" class="d-block">Имя
													пользователя</label>
												<input type="text" id="<?= $str_index ?>reviewer_position" name="reviewer_position" class="form-control" value="<?= $reviewer_position ?>">
											</div>
											<div class="form-group w-100">
												<label for="<?= $str_index ?>review_date" class="d-block">Дата</label>
												<input type="text" id="<?= $str_index ?>review_date" name="review_date" class="form-control" value="<?= $review_date ?>">
											</div>
											<div class="d-flex w-100">
												<div class="form-group w-50 mr-2">
													<label for="<?= $str_index ?>review_pluses" class="d-block">Плюсы</label>
													<textarea name="review_pluses" id="<?= $str_index ?>review_pluses" rows="15" class="form-control"><?= $review_pluses ?></textarea>
												</div>
												<div class="form-group w-50">
													<label for="<?= $str_index ?>review_minuses" class="d-block">Минусы</label>
													<textarea name="review_minuses" id="<?= $str_index ?>review_minuses" rows="15" class="form-control"><?= $review_minuses ?></textarea>
												</div>
											</div>
											<div class="form-group w-100">
												<label for="<?= $str_index ?>company_id" class="d-block">Компании</label>
												<select name="company_id" id="<?= $str_index ?>company_id" class="form-control">
													<?php
													foreach ($companies as $company) {
														$company_name = $company->name;
														$company_id = $company->id;
														$selected = $review->company_id === $company_id ? 'selected' : '';
														echo "<option value='$company_id' $selected>$company_name</option>";
													}
													?>
												</select>
											</div>
											<div class="d-flex w-100">
												<div class="form-group col-3 d-flex align-items-center">
													<input type="hidden" name="is_positive" value="0">
													<?php $checked = $is_positive ? 'checked' : ''; ?>
													<input type="checkbox" id="<?= $str_index ?>is_positive" value="1" name="is_positive" <?php echo $checked; ?>>
													<label for="<?= $str_index ?>is_positive" class="mb-0 ml-2">Положительный</label>
												</div>
                                                <div class="form-group col-3 d-flex align-items-center">
													<input type="hidden" name="is_moderated" value="0">
													<?php $checked = $is_moderated ? 'checked' : ''; ?>
													<input type="checkbox" id="<?= $str_index ?>is_moderated" value="1" name="is_moderated" <?php echo $checked; ?>>
													<label for="<?= $str_index ?>is_moderated" class="mb-0 ml-2">Прошел модерацию</label>
												</div>
											</div>
											<button class="btn btn-success ml-2 mb-2">Сохранить</button>
										</div>
									</form>
								</div>
							<?php
								echo "</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
				<?php
				$lastPage = $reviews->lastPage();
				$currentPage = $reviews->currentPage();
				$width = 2; // на один больше
                    include_view('/admin/table-pagination.php', [
                        'lastPage' => $lastPage,
                        'currentPage' => $currentPage,
                        'width' => $width
                    ]);
				?>

			</section>
		</main>
	</div>

	<script src="/js/formstyler.js"></script>
	<script src="/js/admin.js?<?= time() ?>"></script>
</body>

</html>
