<?php
$exploded = (explode('.', $_SERVER['HTTP_HOST']));
$sub = array_shift($exploded);
?>
<header class="header">
    <nav>
        <a href="/" class="logo"><span>RATING REMONT</span></a>
        <span class="mob-tagline">Правдивый рейтинг<br>Лучшие компании</span>
        <div class="button-menu">
            <span></span>
        </div>
        <menu class="header__menu">
            <li>Меню</li>
            <li><a href="/">Рейтинг</a></li>
            <?php # <li><a href="/rating-hr">Отзывы сотрудников</a></li> ?>
            <li><a href="/all-review">Все отзывы</a></li>
            <li><a href="/contacts">Контакты</a></li>
            <?php if (auth()->isAuthed()) { ?>
                <li><a href="/admin">Админ. панель</a></li><?php } ?>
        </menu>
    </nav>
    <div class="home">
        <div class="home__block">
            <div class="home__item">
                <span><?= $header ?></span>
            </div>
<!--            <div class="home__item">-->
<!--                <div class="home__search-item">-->
<!--                    <input type="text" name="home__search" class="home__search">-->
<!--                    <span>Поиск...</span>-->
<!--                    <i></i>-->
<!--                </div>-->
<!--                <div class="search">-->
<!--                    <div class="search__error">Что желаете найти?</div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</header>
