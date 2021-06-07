<?php


namespace app\Repositories\Base;


use app\Models\Comment;
use app\Repositories\CoreRepository;

class BaseCommentsRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Comment::class;
    }

    public function getUnModeratedCount() : int {
        return $this->startConditions()
            ->where('is_moderated', 0)
            ->count();
    }

}
