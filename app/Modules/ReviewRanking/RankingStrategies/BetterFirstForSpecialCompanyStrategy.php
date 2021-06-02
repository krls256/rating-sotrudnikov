<?php


namespace app\Modules\ReviewRanking\RankingStrategies;


use app\Modules\ReviewRanking\RankingPagination;
use app\Modules\ReviewRanking\Repositories\ReviewRankingRepository;
use app\Modules\ReviewRanking\ReviewRankingConstants;

class BetterFirstForSpecialCompanyStrategy implements IReviewRankingStrategy
{
    protected ReviewRankingRepository $reviewRep;

    public function __construct() {
        $this->reviewRep = new ReviewRankingRepository();
    }

    public function rank(int $company_id, int $page): RankingPagination
    {
        $perPage = ReviewRankingConstants::REVIEWS_PER_PAGE;
        if($page === 1) {
            $reviews = $this->reviewRep->selectFirstPagePagination($company_id, $perPage);

        } else {
            $reviews = $this->reviewRep->selectPagePagination($company_id, $page, $perPage);
        }

        $pagesQuantity = $this->reviewRep->getPagesQuantity($company_id,  $perPage);

        $reviews = $reviews->sortBy('review_hash');
        return new RankingPagination($reviews,
            [
                'lastPage' => $pagesQuantity,
                'currentPage' => $page,
                'firstPage' => 1
            ]);
    }
}
