<?php

use app\Http\Controllers\CommentAdminController;
use app\Repositories\Rest\CommentRestRepository;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$repository = new CommentRestRepository();
$controller = new CommentAdminController($repository);
$controllerData = $controller->index($request);
$comments = $controllerData['comments'];
$companies = $controllerData['companies'];
?>
<!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Таблица комментариев</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>

<body>

<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
    <main class="content">
        <div class="card card-body">
            <h1 class="card-title">Таблица комментариев</h1>
            <?php include_view('/admin/comments/tableControls.php',
                [
                    'request' => $request,
                    'companies' => $companies
                ]); ?>
        </div>
        <?php include_view('/includes/adminMessageBar.php') ?>
        <div class="d-inline-flex card card-body mt-3">
            <form action="" method="get">
                <button class="btn btn-info">Сбросить фильтры</button>
            </form>
        </div>
        <section class="d-flex card card-body mt-3 mb-5">
            <h2>Информация о таблице</h2>
            <ul class="ml-4">
                <li>После изменения формочки соответствующей строки таблицы, таблица пока ещё не меняется, но если в сообщении написано, что таблица обновлена, то она действительно обновлена</li>
            </ul>
        </section>
        <section class="card card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Комментарий</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Компания</th>
                        <th scope="col">Ссылки</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($comments as $comment)
                    {
                        $comment_id = $comment->id;
                        $commenter_name = $comment->fio;
                        $comment_text = $comment->text;
                        $comment_text_cropped = crop($comment_text, 50);
                        $comment_date = $comment->UserDate;
                        $is_moderated = $comment->is_moderated;

                        $review = $comment->review;
                        $review_id = $review->id;
                        $review_pluses = $review->review_pluses;
                        $review_minuses = $review->review_minuses;

                        $company = $review->company;
                        $company_name = $company->name;
                        ?>
                        <tr data-type="table-header" class="<?php if (!$is_moderated) echo 'bg-gray-light' ?>">
                            <th scope="row"><?= $comment_id ?></th>
                            <td><?= $commenter_name ?></td>
                            <td><?= $comment_text_cropped ?></td>
                            <td><?= $comment_date ?></td>
                            <td><?= $company_name ?></td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-primary badge p-2 mr-3" data-action="toggle-control">
                                        Изменить
                                    </button>
                                    <?php if(!$is_moderated) { ?>
                                        <form action="/admin/comments/moderate.php">
                                            <input type="hidden" name="id" value="<?= $comment_id ?>">
                                            <button class="btn btn-warning badge p-2 mr-3">Подтвертидить корректность</button>
                                        </form>
                                    <?php } ?>
                                    <form action="/admin/comments/delete.php">
                                        <input type="hidden" name="id" value="<?= $comment_id ?>">
                                        <button class="btn btn-danger badge p-2">Удалить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr data-type="table-form">
                            <td colspan="5">
                                <div class="d-flex toggleable table-form__wrapper" data-type="form-wrapper">
                                    <div class="table-form__loading">
                                        <div class="spinner-border text-success table-form__spinner">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <form action="/admin/comments/api/update.php" method="post" class="w-100">
                                        <div class="alert alert-danger d-none">
                                        </div>
                                        <div class="alert alert-success d-none">
                                        </div>
                                        <div class="alert alert-warning d-none">
                                        </div>
                                        <input type="hidden" name="id" value="<?= $comment_id ?>">
                                        <input type="hidden" name="review_id" value="<?= $review_id ?>">
                                        <div class="form-group">
                                            <label for="<?= $comment_id ?>-fio">Имя пользователя</label>
                                            <input type="text" name="fio" id="<?= $comment_id ?>-fio"
                                                   class="form-control" value="<?= $commenter_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="<?= $comment_id ?>-date">Дата</label>
                                            <input type="text" name="date" id="<?= $comment_id ?>-date"
                                                   class="form-control" value="<?= $comment_date ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="<?= $comment_id ?>-text">Комментарий</label>
                                            <textarea rows="4" name="text" id="<?= $comment_id ?>-text"
                                                      class="form-control"><?= $comment_text ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="is_moderated" value="0">
                                            <input type="checkbox" <?php if ($is_moderated) echo 'checked'; ?>
                                                   name="is_moderated" value="1"
                                                   id="<?= $comment_id ?>-is_published">
                                            <label for="<?= $comment_id ?>-is_published">Опубликовано</label>
                                        </div>
                                        <div class="form-group">
                                            <h3>Отзыв</h3>
                                            <div class="card card-body">
                                                <b>Плюсы</b>
                                                <p><?= $review_pluses ?></p>
                                                <b>Минусы</b>
                                                <p><?= $review_minuses ?></p>
                                            </div>
                                        </div>
                                        <button class="btn btn-success">Сохранить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
                include_view('/admin/table-pagination.php', [
                    'currentPage' => $comments->currentPage(),
                    'width' => 2,
                    'lastPage' => $comments->lastPage()
                ]);
            ?>
        </section>
    </main>
</div>

<script src="/js/formstyler.js"></script>
<script src="/js/admin.js?<?= time() ?>"></script>
</body>

</html>
