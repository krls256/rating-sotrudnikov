<?php


namespace app\Modules\ReviewRanking\RankingStrategies;


use app\Modules\ReviewRanking\RankingPagination;

interface IReviewRankingStrategy
{
    public function rank(int $company_id, int $page) : RankingPagination;
}