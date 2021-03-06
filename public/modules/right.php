<div class="content__item-right">
    <div class="snippet">
        <div class="snippet__right-title">Советы по поиску работы</div>
        <?php
        $random = rand(1, 6);
        $req = $PDO->prepare("SELECT * FROM `advice` WHERE `id`= $random");
        $req->execute();
        $rowAdvice = $req->fetch();
        ?>
        <div class="snippet__right-text"><?= $rowAdvice['text'] ?></div>
    </div>
    <div class="snippet banner-block">
        <h3><i class="crown"></i>ТОП компаний</h3>
        <ul>
            <?php
            $i = 1;
            foreach ($companiesSide as $bc)
            {
                ?>
                <li>
                    <a href="/otzyvy-sotrudnikov-<?= $bc['url'] ?>/">
                        <span class="banner-block__number"><?= $i ?></span>
                        <span class="banner-block__logo">
                            <img src="/<?= $bc['logo'] ?>" alt="<?= $bc['name'] ?>" />
                          </span>
                        <span class="banner-block__name"><?= $bc['name'] ?></span>
                        <span class="banner-block__next"></span>
                    </a>
                </li>
                <?php $i++;
            } ?>
        </ul>
        <div class="banner-like">Доверяй лучшим!</div>
    </div>
</div>
