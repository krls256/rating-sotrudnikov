<?php if ($count !== 0) { ?>
    <div class="page_nav">
        <?php
        //Ссылки на 1 и на преведущую
        if ($currentPage > 1)
        {
            echo '<a href="/otzyvy-sotrudnikov-' . $companyUrl . '/1' . $postfix .
                '#rew_block" class="oneLink"></a>';  //На первую
            echo '<a href="/otzyvy-sotrudnikov-' . $companyUrl . '/' . $currentPage . $postfix .
                '#rew_block" class="nav-prev"></a>'; //Назад
        }


        //три страницы вперед и назад
        for ($j = 0; $j < $lastPage; $j++)
        {
            $pageNum = $j + 1;
            if ($pageNum >= $start && $pageNum <= $end)
            {

                if ($pageNum === ($currentPage))
                    echo '<a href="/otzyvy-sotrudnikov-' . $companyUrl . '/' . $pageNum . $postfix .
                        '#rew_block" class="active">' . $pageNum . '</a>';
                else
                    echo '<a href="/otzyvy-sotrudnikov-' . $companyUrl . '/' . $pageNum . $postfix . '#rew_block">' .
                        $pageNum . '</a>';
            }
        }

        //На следующую и на последнюю
        if($currentPage < $lastPage)
        {
            echo '<a href="/otzyvy-sotrudnikov-' . $companyUrl . '/' . ($currentPage + 1) . $postfix .
                '#rew_block" class="nav-next"></a>';
            echo '<a href="/otzyvy-sotrudnikov-' . $companyUrl . '/' . ($lastPage) . $postfix .
                '#rew_block" class="lastLimk"></a>';
        }
        ?>
    </div>
<?php } ?>

