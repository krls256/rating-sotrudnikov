<?php


namespace app\Modules\ReviewRanking\RankingActions;


use app\Modules\ReviewRanking\FirstScreenFinder;
use app\Modules\ReviewRanking\Repositories\CompaniesRankingRepository;
use app\Modules\ReviewRanking\Repositories\ReviewRankingRepository;
use app\Modules\ReviewRanking\ReviewRankingConstants;

class ReviseRankingAction implements IRankingAction
{
    protected CompaniesRankingRepository $companiesRep;
    protected ReviewRankingRepository $reviewRep;

    public function __construct() {
        // TODO: implement DI
        $this->companiesRep = new CompaniesRankingRepository();
        $this->reviewRep = new ReviewRankingRepository();
    }

    public function do(): void
    {
        $reviews = $this->reviewRep->getAllReviewsOrderByDate();
        $specialCompanyId = $this->companiesRep->getSpecialCompanyId();
        $this->reviewRep->resetReviewsFirstScreen();
        $groupedReviews = collect([]);
        foreach ($reviews as $review) {
            $value = $groupedReviews->get($review->company_id) ?? collect();
            $value->push($review);
            $groupedReviews->put($review->company_id, $value);
        }
        $finder = new FirstScreenFinder();
        foreach ($groupedReviews as $companyId => $itsReview) {
           if($companyId === $specialCompanyId) {
               $reviewsToBeFirst = $finder->findFirstScreenReviews(
                   $itsReview,
                   ReviewRankingConstants::SPECIAL_FIRST_SCREEN_POSITIVE_REVIEWS,
                   ReviewRankingConstants::SPECIAL_FIRST_SCREEN_NEGATIVE_REVIEWS
               );
           } else {
               $reviewsToBeFirst = $finder->findFirstScreenReviews(
                   $itsReview,
                   ReviewRankingConstants::DEFAULT_FIRST_SCREEN_POSITIVE_REVIEWS,
                   ReviewRankingConstants::DEFAULT_FIRST_SCREEN_NEGATIVE_REVIEWS
               );
           }
           $ids = $reviewsToBeFirst->map(function ($rev) {
               return $rev->id;
           })->toArray();
           $this->reviewRep->setReviewsFirstScreen($ids);
        }

    }

}