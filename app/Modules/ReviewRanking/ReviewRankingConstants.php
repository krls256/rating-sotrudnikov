<?php


namespace app\Modules\ReviewRanking;


use app\Modules\ReviewRanking\RankingStrategies\BetterFirstForSpecialCompanyStrategy;
use app\Modules\ReviewRanking\RankingStrategies\NegativeRankingStrategy;
use app\Modules\ReviewRanking\RankingStrategies\PositiveRankingStrategy;

class ReviewRankingConstants
{
    public const DEFAULT_RANKING_INDEX = 0;
    public const POSITIVE_RANKING_INDEX = 1;
    public const NEGATIVE_RANKING_INDEX = 2;

    public const SPECIAL_COMPANY_NAME = 'Студия Ремонтов';


    public const DEFAULT_FIRST_SCREEN_POSITIVE_REVIEWS = 6;
    public const DEFAULT_FIRST_SCREEN_NEGATIVE_REVIEWS = 2;

    public const SPECIAL_FIRST_SCREEN_POSITIVE_REVIEWS = 8;
    public const SPECIAL_FIRST_SCREEN_NEGATIVE_REVIEWS = 0;

    public const REVIEWS_PER_PAGE = 8;
    public const STRATEGY_MAP = [
        BetterFirstForSpecialCompanyStrategy::class,
        PositiveRankingStrategy::class,
        NegativeRankingStrategy::class
    ];

}