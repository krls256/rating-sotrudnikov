<?php

require_once '../../config.php';

?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Модерация отзывов пользователей</title>
    <?php include_view('/admin/headImports.php'); ?>
</head>

<body>
<div class="page__layout">
    <?php include_view('/admin/adminMenu.php'); ?>
    <main class="content">
        <section class="card p-3">
            <h1>Устройство управления</h1>
            <ul class="pl-4">
                <li>Эта страница нужна для общих преобразований на сайте или в базе данных</li>
            </ul>
        </section>
        <section class="card p-3 mt-5">
            <h2>Управление отзывами</h2>
            <ul class="list-unstyled d-flex flex-column">
                <li class="card-body">
                    <h3>Нормализация отзывов</h3>
                    <p>В таблице с отзывами из можно публиковать в ручную, что может привести нас к тому, что у
                        какая-то компания будет выше чем СР, для избежания этого можно нормализовать базу
                    </p>
                    <form action="review/normalize.php" method="post">
                        <button class="btn btn-info">Нормализовать</button>
                    </form>
                </li>
            </ul>
        </section>
    </main>
</div>
<script src="/js/formstyler.js"></script>
<script src="/js/admin.js?<?= time() ?>"></script>
</body>
</html>
