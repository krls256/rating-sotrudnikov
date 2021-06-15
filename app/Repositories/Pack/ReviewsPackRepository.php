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
        foreach ($data as $i => $review) {
            $data[$i]['review_hash'] = Review::getHash($review['review_pluses'], $review['review_minuses']);
        }
        return $this->startConditions()->insert($data);
    }

}
