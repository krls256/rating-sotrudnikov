<?php


use app\Http\Controllers\Rest\UserRequestRestController;
use app\Repositories\Rest\UserRequestRestRepository;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$repository = new UserRequestRestRepository();
$controller = new UserRequestRestController($repository);

$controllerData = $controller->index($request);
$userRequests = $controllerData['userRequests'];
$companies = $controllerData['companies'];

?>
<!DOCTYPE html>
<html lang="ru-Ru" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Таблица заявок</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>

<body>

<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
    <main class="content">
        <?php include_view('/includes/adminMessageBar.php') ?>
        <div class="card card-body">
            <h1 class="card-title">Таблица заявок</h1>
            <?php include_view('/admin/userRequests/tableControls.php',
                [
                    'request' => $request,
                    'companies' => $companies
                ]); ?>
        </div>
        <div class="d-inline-flex flex-row card card-body mt-3">
            <form action="" method="get">
                <button class="btn btn-info">Сбросить фильтры</button>
            </form>
            <form action="" method="get" class="ml-4">
                <input type="hidden" name="is_watched" value="0">
                <input type="hidden" name="pagination" value="0">
                <button class="btn btn-info">Показать новые заявки</button>
            </form>
        </div>
        <section class="d-flex card card-body mt-3 mb-5">
            <h2>Информация о таблице</h2>
            <ul class="ml-4">
                <li>После изменения формочки соответствующей строки таблицы, таблица пока ещё не меняется, но если в
                    сообщении написано, что таблица обновлена, то она действительно обновлена
                </li>
            </ul>
        </section>
        <section class="card card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Номер</th>
                        <th scope="col">Компания</th>
                        <th scope="col">Просмотрено</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($userRequests as $ur)
                    {
                        $ur_id = $ur->id;
                        $user_name = $ur->user_name;
                        $user_phone = $ur->user_phone;
                        $company_name = $ur->company->name;
                        $is_watched = $ur->is_watched;
                        $is_watched_class = $is_watched ? 'i i-success' : 'i i-attention';
                        $is_watched_text = $is_watched ? 'Просмотрено' : 'Не просмотрено';
                        ?>

                        <tr>
                            <th scope="col"><?= $ur_id ?></th>
                            <td scope="col"><?= $user_name ?></td>
                            <td scope="col"><?= $user_phone ?></td>
                            <td scope="col"><?= $company_name ?></td>
                            <td scope="col">
                                <div class="d-flex">
                                    <span class="<?= $is_watched_class ?>"></span>
                                    <span class="ml-2"><?= $is_watched_text ?></span>
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
                'currentPage' => $userRequests->currentPage(),
                'width' => 2,
                'lastPage' => $userRequests->lastPage()
            ]);
            ?>
        </section>
    </main>
</div>

<script src="/js/formstyler.js"></script>
<script src="/js/admin.js?<?= time() ?>"></script>
</body>

</html>
