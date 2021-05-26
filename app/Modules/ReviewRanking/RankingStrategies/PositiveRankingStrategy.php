<?php


namespace app\Modules\ReviewRanking\RankingStrategies;


use app\Modules\ReviewRanking\RankingPagination;
use app\Modules\ReviewRanking\Repositories\ReviewRankingRepository;
use app\Modules\ReviewRanking\ReviewRankingConstants;

class PositiveRankingStrategy implements IReviewRankingStrategy
{

    protected ReviewRankingRepository $reviewRep;

    public function __construct() {
        $this->reviewRep = new ReviewRankingRepository();
    }

    public function rank(int $company_id, int $page): RankingPagination
    {
        $perPage = ReviewRankingConstants::REVIEWS_PER_PAGE;
        $reviews = $this->reviewRep->getPositivePagePagination($company_id, $page, $perPage);
        $pagesQuantity = $this->reviewRep->getPositivePagesQuantity($company_id, $perPage);

        return new RankingPagination($reviews,
            [
                'lastPage' => $pagesQuantity,
                'currentPage' => $page,
                'firstPage' => 1
            ]);
    }
}