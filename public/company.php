<?php
include "function.php";

use app\Http\Controllers\User\CompanyPageController;
use app\Repositories\Base\BaseSettingsRepository;
use app\Repositories\SingleEntity\CompanySingleEntityRepository;
use helperClasses\Request;


$settingsRepo = new BaseSettingsRepository();
$set = $settingsRepo->getSetting();


$request = new Request();

$controller = new CompanyPageController();
$companyRepository = new CompanySingleEntityRepository();

$dataToFormat = $controller->index($request, $companyRepository);
$type = $request->get('type');
if ($type)
    $postfix = "/$type";
else
    $postfix = '';
$row = $dataToFormat['company'];
$company = &$row;
$companiesSide = $dataToFormat['companies'];
$pagination = $dataToFormat['pagination'];
$row_id = $row['id'];
$pages = $pagination->lastPage();
$page = $pagination->currentPage();

?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <title>Отзывы сотрудников о компании «<?= $row['name'] ?>»</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="Актуальные отзывы сотрудников о компании
	«<?= $row['name'] ?>»<?php

    $dp = $page;
    if ($page != 1)
    {
        echo " — страница " . $dp;
    } ?>. Почитайте отзывы, напишите свой или оставьте заявку на обратный звонок.">
    <?php
    //Линки next и prev
    if ($page + 1 === 1)
    {
        echo '<link rel="next" href="https://' . $_SERVER['HTTP_HOST'] . '/otzyvy-sotrudnikov-' . $row->url . '/2' .
            $postfix . '" />';                    //следующая
    } else if ($page + 1 === $pages - 1)
    {
        echo '<link rel="prev" href="https://' . $_SERVER['HTTP_HOST'] . '/otzyvy-sotrudnikov-' . $row->url . '/' .
            ($page + 1) . $postfix . '"/>';  //Назад
    } else
    {
        echo '<link rel="next" href="https://' . $_SERVER['HTTP_HOST'] . '/otzyvy-sotrudnikov-' . $row->url . '/' .
            ($page + 2) . $postfix . '" />'; //следующая
        echo '<link rel="prev" href="https://' . $_SERVER['HTTP_HOST'] . '/otzyvy-sotrudnikov-' . $row->url . '/' .
            ($page) . $postfix . '"/>';      //Назад
    }

    //Указываем каноникал везде кроме главной
    if (!empty($_GET['page']))
        echo '<link rel="canonical" href="https://' . $_SERVER['HTTP_HOST'] . '/otzyvy-sotrudnikov-' . $row->url .
            '/"/>';
    ?>

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Рейтинг ремонтных компаний по отзывам сотрудников">
    <meta property="og:title"
          content="Отзывы сотрудников о компании «<?= $row['name'] ?>» — Топ рейтиг ремонтных компаний" />
    <meta property="og:description" content="Актуальные отзывы сотрудников о компании «<?= $row['name'] ?>»<?php $dp
        = $page + 1;
    if ($page + 1 != 1)
    {
        echo " — страница " . $dp;
    } ?>. Почитайте отзывы, напишите свой или оставьте заявку на обратный звонок." />
    <meta property="og:url" content="https://<?= $_SERVER['HTTP_HOST'] ?>/otzyvy-sotrudnikov-<?php echo $row->url;
    ?>/" />
    <meta property="og:image" content="https://<?= $_SERVER['HTTP_HOST'] ?>/images/logo.png" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css?<?= time() ?>">
    <link rel="stylesheet" href="/css/formstyler.css">
    <script src="/js/jquery.js"></script>
</head>
<body>
<div class="wrapper">
    <?php mv_header($set['header']); ?>
    <div class="content">
        <div class="content__item-left">
            <div class="snippet company">
                <div class="company__title">
                    <h1>Отзывы сотрудников о компании <?= $row['name'] ?></h1>
                    <span>Дата основания: <?= date('d.m.Y', $row['data']) ?></span>
                </div>
                <div class="compaty__item">
                    <div>
                        <img src="/<?= $row['logo'] ?>" alt="<?= $row['name'] ?>">
                    </div>
                    <div class="company__attributes">
                        <div>
                            <span>Телефон: </span>
                            <span><?= $row['phone'] ?></span>
                        </div>
                        <div>
                            <span>Сайт: </span>
                            <span><a href="<?= $row['sity'] ?>" class="company__sity"
                                     target="_blank"><?= $row->ProtocolAndSiteDomain ?></a></span>
                        </div>
                        <div>
                            <span>Адрес: </span>
                            <span><?= $row['address'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="company__map" id="c_map"></div>
                <div class="company__discription">
                    <h2 class="discription_company">Описание компании <?= $row['name'] ?>: </h2>
                    <div><?= $row['description'] ?></div>
                    <div><b>ИНН компании: </b><?= $row['inn'] ?></div>
                    <?php if (($row['vk'] or $row['fb'] or $row['ins'] or $row['ok'] or $row['tg'] or $row['vb'] or
                            $row['wa']
                            or $row['yb'] or $row['tw']) != '')
                    { ?>
                        <div><b>Соц. сети компании:</b></div>
                        <div class="social-network">
                            <?php if ($row['vk'] != '') { ?><a href="<?= $row['vk'] ?>" class="vk"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['fb'] != '') { ?><a href="<?= $row['fb'] ?>" class="fb"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['ins'] != '') { ?><a href="https://www.instagram.com/<?= $row['ins'] ?>/"
                                                                class="ins"
                                                                target="_blank"></a><?php } ?>
                            <?php if ($row['ok'] != '') { ?><a href="<?= $row['ok'] ?>" class="ok"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['tg'] != '') { ?><a href="<?= $row['tg'] ?>" class="tg"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['vb'] != '') { ?><a href="<?= $row['vb'] ?>" class="vb"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['wa'] != '') { ?><a href="<?= $row['wa'] ?>" class="wa"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['yb'] != '') { ?><a href="<?= $row['yb'] ?>" class="yb"
                                                               target="_blank"></a><?php } ?>
                            <?php if ($row['tw'] != '') { ?><a href="<?= $row['tw'] ?>" class="tw"
                                                               target="_blank"></a><?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="snippet snippet-title" id="rew_block">
                <h2>Отзывы сотрудников о компании <?= $row['name'] ?></h2>
            </div>
            <div class="button-panel">
                <button class="company__bottom-green review_modal" data-id="<?= $row['id'] ?>"
                        data-key="<?= $func->hash($row_id) ?>" data-type="review">Написать отзыв
                </button>
                <button class="company__bottom-green request_modal" data-id="<?= $row['id'] ?>"
                        data-key="<?= $func->hash($row_id) ?>" data-type="request" data-val="hr">Оставить заявку
                </button>
            </div>
            <!--review-->
            <?php
            $countReview = $pagination->count();

            if ($countReview > 0)
            {
                foreach ($pagination as $review)
                {
                    $reviewID = $review['id'];
                    ?>
                    <div class="snippet review">
                        <div class="review__header">
                            <div class="review__user">
                                <b><?= $review->ReviewerNameForUser ?></b>
                                <span>оставил(а) отзыв</span>
                                <span>о "<a href="<?= $row['sity']; ?>"><?= $row['name'] ?></a>"</span>
                            </div>
                            <div class="review__like <?php echo $review['is_positive'] == 1 ? 'positive' :
                                'negativ'; ?>">
                                <i></i>
                                <?php echo $review['is_positive'] == 1 ? 'Рекомендую' : 'Не рекомендую'; ?>
                            </div>
                        </div>
                        <div class="review__text">
                            <?php
                            $pluses = $review['review_pluses'];
                            $minuses = $review['review_minuses'];
                            if ($pluses)
                            {
                                $plusesClear = htmlspecialchars_decode($pluses);
                                echo "<span class='review__label mt-0 mb-2'>Плюсы</span>";
                                echo "<p  class='mt-0 mb-2'>$plusesClear</p>";
                            }
                            if($minuses) {
                                $minusesClear = htmlspecialchars_decode($minuses);
                                echo "<span class='review__label mt-0 mb-2'>Минусы</span>";
                                echo "<p>$minusesClear</p>";
                            }
                            ?>
                        </div>
                        <div class="review__footer">
                            <span><?php echo $review->UserDate; ?></span>
                            <button type="button" class="company__bottom-green comment_modal"
                                    data-id="<?= $review['id'] ?>" data-key="<?= $func->hash($review['id']); ?>"
                                    data-type="comment" data-val="hr">КОММЕНТИРОВАТЬ
                            </button>
                            <?php if (isset($_SESSION['id']) != '') { ?><a
                                href="/admin/moderation_edit?id=<?= $reviewID ?>"><i></i></a><?php } ?>
                        </div>
                        <!--comment-->
                        <?php
                        if ($review->comments->count())
                        {
                            ?>
                            <div class="comments">
                                <div class="comments__title">Комментарии</div>
                                <?php
                                foreach ($review->comments as $comment)
                                {
                                    ?>
                                    <div class="comments__item">
                                        <div class="comments__header">
                                            <?= $comment['fio'] ?>
                                        </div>
                                        <div class="comments__text">
                                            <?= $comment['text'] ?>
                                        </div>
                                        <div class="comments__footer">
                                            <?= $comment->UserDate ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <!--comment-->
                    </div>
                <?php } ?>
                <!--review-->

                <!--pageSpeed-->
                <?php
                $pagination->printPagination($request->get('type'), $row->url);
                ?>
                <!--pageSpeed-->

            <?php } else { ?>
                <div class="snippet">
                    <div class="noReview">
                        <div>У компании нет отзывов! Оставь отзыв первым <i></i></div>
                        <button class="company__bottom-green review_modal" data-id="<?= $row['id'] ?>"
                                data-key="<?= $key ?>" data-type="review">Написать отзыв
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php include 'modules/right.php' ?>
    </div>
    <?php include 'modules/footer.php'; ?>
    <?php include 'modules/modal.php'; ?>
</div>
<script>function MapInit() {
        var e = new ymaps.Map("c_map", {
            center: [<?=$row['map']?>],
            zoom: 17,
            controls: ["routeButtonControl", "typeSelector", "fullscreenControl", "zoomControl"]
        });
        e.behaviors.disable("scrollZoom");
        var o = new ymaps.GeoObject({geometry: {type: "Point", coordinates: [<?=$row['map']?>]}});
        e.geoObjects.add(o)
    }

    window.onload = function () {
        e = document.createElement("script"), e.src = "https://api-maps.yandex.ru/2.1/?apikey=a6da9518-c21f-41f1-80f6-8fb6ae90ea25&lang=ru_RU&onload=MapInit", document.getElementsByTagName("body")[0].appendChild(e)
    };</script>
<?php include 'modules/scripts.php'; ?>
<?php include_view('/user_includes/yandex_metrika.php'); ?>
</body>
</html>
