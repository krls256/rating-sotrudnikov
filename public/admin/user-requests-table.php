<?php


use app\Http\Controllers\CRUD\UserRequestCRUDController;
use app\Repositories\Rest\UserRequestRestRepository;
use helperClasses\Request;

require_once '../../config.php';

$request = new Request();
$repository = new UserRequestRestRepository();
$controller = new UserRequestCRUDController($repository);

$controllerData = $controller->index($request);
$userRequests = $controllerData['userRequests'];

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
        <?php include_view('/includes/adminMessageBar.php') ?>
        <section class="d-flex card card-body mt-3 mb-5">
            <h2>Информация о таблице</h2>
            <ul class="ml-4">
                <li>После изменения формочки соответствующей строки таблицы, таблица пока ещё не меняется, но если в
                    сообщении написано, что таблица обновлена, то она действительно обновлена
                </li>
            </ul>
        </section>
        <section class="card card-body">
            <h2 class="card-title">Таблица заявок</h2>
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
