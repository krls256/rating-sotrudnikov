<?php


namespace app\Modules\ReviewRanking;

use Illuminate\Support\Collection;

class FirstScreenFinder
{

    public function findFirstScreenReviews(Collection $reviews, $positive_quantity, $negative_quantity): Collection
    {
        $positive = $reviews->where('is_positive', 1)
            ->sortByDesc('review_date')
            ->take($positive_quantity);
        $negative = $reviews->where('is_positive', 0)
            ->sortByDesc('review_date')
            ->take($negative_quantity);
        return $positive->merge($negative);
    }
}