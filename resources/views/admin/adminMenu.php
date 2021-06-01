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
        <li><a href="/admin/create-company">Добавить компанию</a></li>
        <li><a href="/admin/page-edit-com">Ред. компаний</a></li>
        <li><a href="/admin/create-review">Добавить отзыв</a></li>
        <li class="review-table"><a href="/admin/review-table">Таблица отзывов</a></li>
        <?php if (($set['moderation'] ?? null) == 0) { ?>
            <li class="harmonic active">
                <div>Модирация отзывов</div>
                <ul>
                    <li><a href="/admin/moderation?type=user">Пользователи<span><?= $UnModeratedCount ?></span></a></li>
                </ul>
            </li>
        <?php } ?>
        <li class="review-table"><a href="/admin/control-unit">Устройство управления</a></li>
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
