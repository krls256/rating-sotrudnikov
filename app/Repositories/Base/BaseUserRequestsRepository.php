<?php


namespace app\Repositories\Base;


use app\Models\UserRequest;
use app\Repositories\CoreRepository;

class BaseUserRequestsRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return UserRequest::class;
    }

    public function getUnWatchedCount() : int {
        return $this->startConditions()
            ->where('is_watched', 0)
            ->count();
    }

}
