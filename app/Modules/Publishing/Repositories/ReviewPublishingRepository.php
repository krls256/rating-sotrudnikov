<?php


namespace app\Modules\Publishing\Repositories;


use app\Models\Review;
use app\Repositories\CoreRepository;

class ReviewPublishingRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Review::class;
    }

    public function publishReviews(int $company_id, bool $positive, int $quantity) {
        return $this->startConditions()
            ->select('id')
            ->where('company_id', $company_id)
            ->where('is_moderated', 1)
            ->where('is_published', 0)
            ->where('is_positive', $positive)
            ->take($quantity)
            ->update(['is_published' => 1]);
    }

    public function unpublishReviews(int $company_id, bool $positive, int $quantity) {
        return $this->startConditions()
            ->select('id')
            ->where('company_id', $company_id)
            ->where('is_moderated', 1)
            ->where('is_published', 1)
            ->where('is_positive', $positive)
            ->take($quantity)
            ->update(['is_published' => 0]);
    }
}
