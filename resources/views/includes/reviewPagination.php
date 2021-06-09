<!--$count-->
<!--$currentPage-->
<!--$lastPage-->
<!--$start-->
<!--$end-->
<!--$prefix-->
<!--$postfix-->

<?php if ($count !== 0) { ?>
    <div class="page_nav">
        <?php
        //Ссылки на 1 и на преведущую
        if ($currentPage > 1)
        {
            echo '<a href="' . $prefix . '1' . $postfix . '" class="oneLink"></a>';  //На первую
            echo '<a href="' . $prefix . ($currentPage - 1) . $postfix . '" class="nav-prev"></a>'; //Назад
        }


        //три страницы вперед и назад
        for ($j = 0; $j < $lastPage; $j++)
        {
            $pageNum = $j + 1;
            if ($pageNum >= $start && $pageNum <= $end)
            {

                if ($pageNum === ($currentPage))
                    echo '<a href="' . $prefix . $pageNum . $postfix .
                        '" class="active">' . $pageNum . '</a>';
                else
                    echo '<a href="' . $prefix . $pageNum . $postfix . '">' .
                        $pageNum . '</a>';
            }
        }

        //На следующую и на последнюю
        if($currentPage < $lastPage)
        {
            echo '<a href="' . $prefix . ($currentPage + 1) . $postfix . '" class="nav-next"></a>';
            echo '<a href="' . $prefix . ($lastPage) . $postfix . '" class="lastLimk"></a>';
        }
        ?>
    </div>
<?php } ?>

