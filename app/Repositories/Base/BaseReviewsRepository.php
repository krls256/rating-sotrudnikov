<?php


namespace app\Repositories\Base;


use app\Repositories\CoreRepository;
use app\Models\Review as Model;
use Illuminate\Support\Collection;

class BaseReviewsRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getCount() : int {
        return $this->startConditions()
            ->count();
    }

    public function getUnpublishedCount() : int {
        return $this->startConditions()
            ->where('is_published', 0)
            ->count();
    }

    public function getUnModeratedCount() : int {
        return $this->startConditions()
            ->where('is_moderated', 0)
            ->count();
    }

    public function getReviewsHashes() : Collection {
        return $this->startConditions()
            ->select(['id', 'review_hash'])
            ->toBase()
            ->get();
    }

}
