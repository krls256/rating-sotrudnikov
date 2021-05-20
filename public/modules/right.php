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
        <?php
        $bannersCom = $PDO->prepare("SELECT *, 
                                        (select count(*) from `review` where `company_id` = company.id) as `sort`, 
                                        if(`position`, `position`, 9999) as 'pos' 
                                      FROM `company` WHERE 
                                        `dev` IS NULL 
                                      ORDER BY 
                                        `pos` ASC, `sort` 
                                      DESC LIMIT 5");

        $bannersCom->execute();
        ?>
		<ul>
            <?php
            $i = 1;
            while ($bc = $bannersCom->fetch())
            {
                ?>
				<a href="/otzyvy-sotrudnikov-<?= $bc['url'] ?>/">
					<li>
						<span class="banner-block__number"><?= $i ?></span>
						<span class="banner-block__logo">
            <img src="/<?= $bc['logo'] ?>" alt="<?= $bc['name'] ?>" />
          </span>
						<span class="banner-block__name"><?= $bc['name'] ?></span>
						<span class="banner-block__next"></span>
					</li>
				</a>
                <?php $i++;
            } ?>
		</ul>
		<div class="banner-like">Доверяй лучшим!</div>
	</div>
</div>
