<?php


namespace app\Repositories\Base;


use app\Repositories\CoreRepository;
use app\Models\Review as Model;

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

}