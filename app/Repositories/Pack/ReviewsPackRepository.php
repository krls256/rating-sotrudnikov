<?php


namespace app\Repositories\Pack;


use app\Models\Review;
use app\Repositories\CoreRepository;

class ReviewsPackRepository extends CoreRepository implements IPackRepository
{
    protected function getModelClass()
    {
        return Review::class;
    }

    public function insert(array $data)
    {
        return $this->startConditions()->insert($data);
    }

}
