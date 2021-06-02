<?php
foreach ($reviews as $row)
{
    $idCom = $row['company_id'];
    $company = $row->company;
    ?>
    <div class="last-review__item">
        <div class="last-review__header">
                   <span><b><?= $row->ReviewerNameForUser ?></b> об <a
                           href="/otzyvy-sotrudnikov-<?= $company['url'] ?>#rew_block">"<?= $company['name'] ?>"</a></span>
        </div>
        <div class="last-review__body">
            <?php
            $pluses = $row['review_pluses'];
            $minuses = $row['review_minuses'];
            if ($pluses)
            {
                $plusesClear = crop(htmlspecialchars_decode($pluses), 200);
                echo "<span class='review__small-label mt-0 mb-1'>Плюсы</span>";
                echo "<p >$plusesClear</p>";
            }
            if ($minuses)
            {
                $minusesClear = crop(htmlspecialchars_decode($minuses), 200);
                echo "<span class='review__small-label mt-0 mb-1'>Минусы</span>";
                echo "<p>$minusesClear</p>";
            }
            ?>
        </div>
        <div class="last-review__footer"><span><?php echo $row->UserDate; ?></span><a
                href="/otzyvy-sotrudnikov-<?=
                $company['url'] ?>#rew_block">Читать</a></div>
    </div>
<?php } ?>
