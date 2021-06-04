<footer>
    <nav>
        <a href="#" class="logo">RATING REMONT</a>
        <menu class="header__menu">
            <li><a href="/">Рейтинг</a></li>
            <li><a href="/all-review">Все отзывы</a></li>
            <li><a href="/contacts">Контакты</a></li>
        </menu>
    </nav>
    <div class="copy">При использовании материалов гиперссылка на <?= $_SERVER['HTTP_HOST'] ?>
        обязательна.<br /><span>©<?= date('Y') ?> Все права защищены.</span></div>
</footer>
<div class="modal">
    <div class="modal__window window__review">
        <div class="modal__overlay d-none" data-overlay="review">
            <div class="modal__spinner spin"></div>
        </div>
        <h3>Оставить отзыв<span class="close"></span></h3>
        <div class="modal__error"></div>
        <form class="modal__item" id="review">
            <input type="hidden" name="company_id" value="<?php echo ($company->id)?>">
            <label>
                <span>Имя <b>*</b></span>
                <input type="text" name="reviewer_name" value="" data-check="true">
            </label>
            <label>
                <span>Должность <b>*</b></span>
                <input type="text" name="reviewer_position" value="" data-check="true">
            </label>
            <label>
                <span>Что вам понравилось в данной компании? <b>*</b></span>
                <textarea name="review_pluses"></textarea>
            </label>
            <label>
                <span>Что вам не понравилось? <b>*</b></span>
                <textarea name="review_minuses"></textarea>
            </label>
            <div class="modal__like">
                <span data-like="1">Рекомендую</span>
                <span data-like="0">Не рекомендую</span>
            </div>
            <button class="company__bottom-green send-review">Отправить</button>
        </form>
    </div>
    <div class="modal__window window__comment">
        <div class="modal__overlay d-none" data-overlay="comment">
            <div class="modal__spinner spin"></div>
        </div>
        <h3>Коментировать отзыв<span class="close"></span></h3>
        <div class="modal__error"></div>
        <form class="modal__item" id="comment">
            <input type="hidden" name="review_id" value="" data-check="true" />
            <input type="hidden" name="key" value="" data-check="true" />
            <input type="hidden" name="type" value="" data-check="true" />
            <label>
                <span>Имя <b>*</b></span>
                <input type="text" name="fio" value="" data-check="true">
            </label>
            <label>
                <span>Комментарий <b>*</b></span>
                <textarea name="text" data-check="true"></textarea>
            </label>
            <button type="submit" class="company__bottom-green send-comment">Отправить</button>
        </form>
    </div>
    <div class="modal__window window__request">
        <div class="modal__overlay d-none" data-overlay="request">
            <div class="modal__spinner spin"></div>
        </div>
        <h3>Оставить заявку<span class="close"></span></h3>
        <div class="modal__error"></div>
        <form class="modal__item" id="request">
            <input type="hidden" name="company_id" value="<?php echo ($company->id)?>" data-check="true" />
            <label>
                <span>Имя <b>*</b></span>
                <input type="text" name="user_name" value="" data-check="true">
            </label>
            <label>
                <span>Телефон <b>*</b></span>
                <input type="text" name="user_phone" value="" placeholder="+7(___) ___-__-__">
            </label>
            <button  class="company__bottom-green send-request">Отправить</button>
        </form>
    </div>
</div>
