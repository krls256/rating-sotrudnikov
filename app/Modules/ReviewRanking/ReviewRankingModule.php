<?php


namespace app\Modules\ReviewRanking;


use app\Modules\ReviewRanking\RankingStrategies\IReviewRankingStrategy;
use ErrorException;

class ReviewRankingModule
{
    /**
     * @param int $company_id
     * @param int $page
     * @param int $typeOfRanking
     * @return RankingPagination
     * @throws ErrorException
     */
    public function getRankingPagination(
        int $company_id, int $page, int $typeOfRanking) : RankingPagination {
        $strategyClass = ReviewRankingConstants::STRATEGY_MAP[$typeOfRanking] ?? null;
        if($strategyClass) {
            /** @var IReviewRankingStrategy $strategy */
            $strategy = new $strategyClass();
            $pagination = $strategy->rank($company_id, $page);
        } else {
            throw new ErrorException("Unknown strategy at ".__METHOD__);
        }

        return $pagination;
    }
}