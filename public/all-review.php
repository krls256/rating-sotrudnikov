<?php

use app\Http\Controllers\User\AllReviewsPageController;
use app\Repositories\Base\BaseSettingsRepository;
use helperClasses\Request;

require_once "function.php";

$show = 10;
$settingsRepo = new BaseSettingsRepository();
$set = $settingsRepo->getSetting();

$request = new Request();
$controller = new AllReviewsPageController();
$controllerData = $controller->index($request, 10);
$companiesSide = $controllerData['companies'];
$reviews = $controllerData['reviews'];

//Количество записей
// TODO: add is publish check
$count =
    $PDO->query("SELECT * FROM `review` WHERE `review_pluses` != '' and `review_minuses` != '' and `is_published` = 1");
$total = $count->rowCount();

//Номера страниц
$page = $_GET['page'] ?? '';
if (!is_numeric($page) or $page < 1) $page = 1;

//Количество страниц
$pages = $total / $show;
$pages = ceil($pages);
$pages++;

if ($page > $pages) $page = 1;
if (!isset($list)) $list = 0;

$list = --$page * $show;

$sqlDev = (!empty($_SESSION['id']) and $_SESSION['id'] != '') ? '' : 'and c.dev IS NULL';

$commentQuery = $PDO->query("SELECT
                                    r.id,
                                    c.dev,
                                    r.reviewer_position,
                                    r.is_positive,
                                    r.review_pluses,
       								r.review_minuses,
                                    r.company_id,
                                    r.review_date,
                                    r.is_published
                                FROM
                                  `review` r
                                LEFT OUTER JOIN `company` c ON
                                  r.company_id = c.id
                                WHERE
                                  r.review_pluses != '' and r.review_minuses != '' $sqlDev and r.is_published = 1
                                ORDER BY r.review_date DESC LIMIT $show OFFSET $list");

$сurrent = $page + 1;  //Текущая страница
$start = $сurrent - 3; //перед текущей
$end = $сurrent + 3;   //После текущей

//Форматирование description
$dp = $page + 1;
$getDes = $set['all_rev_des'];

if ($page + 1 != 1)
{
    $echoPage = "— страница " . $dp;
    $echoDes = sprintf($getDes, $echoPage);
} else
{
    $echoDes = str_replace(' %s', "", $getDes);
}
?>
<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <title><?php echo $set['all_rev_title']; ?></title>
    <meta name="description" content="<?= $echoDes ?>">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/main.css?<?= time() ?>">
    <link rel="stylesheet" href="/css/formstyler.css">
    <link rel="canonical" href="https://<?= $_SERVER['HTTP_HOST'] ?>/all-review" />
    <?php
    if ($page + 1 == 1)
    {
        echo '<link rel="next" href="https://' . $_SERVER['HTTP_HOST'] .
            '/all-review?page=2" />';              //следующая
    } else if ($page + 1 == $pages - 1)
    {
        echo '<link rel="prev" href="https://' . $_SERVER['HTTP_HOST'] . '/all-review?page=' . ($page + 1) .
            '"/>';  //Назад
    } else
    {
        echo '<link rel="next" href="https://' . $_SERVER['HTTP_HOST'] . '/all-review?page=' . ($page + 2) .
            '" />';   //следующая
        echo '<link rel="prev" href="https://' . $_SERVER['HTTP_HOST'] . '/all-review?page=' . ($page) .
            '"/>';    //Назад
    }
    ?>

    <script src="js/jquery.js"></script>
</head>
<body>
<div class="wrapper">
    <?php mv_header($set['header']); ?>
    <div class="content">
        <div class="content__item-left">
            <div class="snippet">
                <h1><?php echo $set['all_rev_h1']; ?></h1>
                <p class="index__text"><?php echo $set['all_rev_text']; ?></p>
            </div>
            <?php
            if ($reviews->count() > 0)
            {
                foreach ($reviews as $review)
                {
                    $reviewID = $review['id'];
                    $company = $review->company;
                    ?>
                    <div class="snippet review">
                        <div class="review__header">
                            <div class="review__user">
                                <b><?= $review->ReviewerNameForUser ?></b>
                                <span>оставил(а) отзыв</span>
                                <span>о "<a href="<?= $company['sity']; ?>"><?= $company['name'] ?></a>"</span>
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
                <div class="page_nav">
                <?php
                    $currentPage = $reviews->currentPage();

                    include_view('/includes/reviewPagination.php', [
                        'count' =>  $reviews->count(),
                        'currentPage' => $currentPage,
                        'lastPage' => $reviews->lastPage(),
                        'start' => $currentPage - 3,
                        'end' => $currentPage + 3,
                        'prefix' => '/all-review?page=',
                        'postfix' => ''
                    ]);
                ?></div><?php
            } else
            {
                ?>
                <div class="snippet">
                    <span class="noReview">У компании нет отзывов! Оставь отзыв первым <i></i></span>
                </div>
                <?php
            } ?>
        </div>
        <?php include 'modules/right.php'; ?>
    </div>
    <?php include 'modules/footer.php'; ?>
    <?php include 'modules/modal.php'; ?>
</div>
<?php include 'modules/scripts.php'; ?>
<?php include_view('/user_includes/yandex_metrika.php'); ?>
</body>
</html>
