<?php
//количество неопубликованных пользовательских отзывов
use app\Repositories\Base\BaseReviewsRepository;

$repository = new BaseReviewsRepository();
$UnModeratedCount = $repository->getUnModeratedCount();

?>
<div class="menu">
    <a href="/admin/">
        <div class="menu__logo">RATING <span>SOTRUDNIKOV</span></div>
    </a>
    <ul class="menu__link">
        <li><a class="i-exclamation" href="/admin/create-company">Добавить компанию</a></li>
        <li><a class="i-edit" href="/admin/page-edit-com">Ред. компаний</a></li>
        <li><a class="i-article" href="/admin/create-review">Добавить отзыв</a></li>
        <li><a class="i-review" href="/admin/review-table">Таблица отзывов</a></li>
        <li><a class="i-comment" href="/admin/comments-table">Таблица комментариев</a></li>
        <?php if (($set['moderation'] ?? null) == 0) { ?>
            <li class="harmonic active">
                <div class="i-moderation">Модирация отзывов</div>
                <ul>
                    <li><a href="/admin/moderation?type=user">Пользователи<span><?= $UnModeratedCount ?></span></a></li>
                </ul>
            </li>
        <?php } ?>
        <li><a class="i-gear" href="/admin/control-unit">Устройство управления</a></li>
    </ul>
    <ul class="menu__link">
            <li>
	            <a href="/">На главную</a>
            </li>
            <li>
	            <a href="/admin/exit">Выйти</a>
            </li>

    </ul>
</div>
