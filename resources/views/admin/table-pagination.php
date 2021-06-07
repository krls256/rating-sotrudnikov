<?php
$needPagination = $request->get('pagination') !== '0';
$lastPage = $lastPage;
$firstPage = 1;
$currentPage = $currentPage;
$width = $width + 1; // на один больше

if($needPagination) {
?>
<div class="table__pagination d-flex justify-content-center">
    <div class="pagination">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                if ($currentPage > $firstPage) {
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?= $firstPage ?>">
                            <i class="bi bi-chevron-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?= $currentPage - 1 ?>">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <?php
                for ($i = $currentPage - 1; $i > $currentPage - $width; $i--) {
                    $page = $i;
                    if ($page >= $firstPage)
                        echo "<li class='page-item'><a class='page-link' href='#' data-page='$page' >$page</a></li>";
                }
                echo "<li class='page-item active'><span class='page-link' >$currentPage</span></li>";
                for ($i = 1; $i < $width; $i++) {
                    $page = $currentPage + $i;
                    if ($page <= $lastPage)
                        echo "<li class='page-item'><a class='page-link' href='#' data-page='$page' >$page</a></li>";
                }
                ?>
                <?php
                if ($currentPage < $lastPage) {
                    ?>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?= $currentPage + 1 ?>">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?= $lastPage ?>">
                            <i class="bi bi-chevron-double-right"></i>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
</div>
<?php } ?>
