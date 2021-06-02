<?php


namespace app\Repositories\SingleEntity;


use app\Models\User;
use app\Repositories\CoreRepository;

class UserSingleEntityRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return User::class;
    }

    public function getUserByLogin(string $login) : ?User {
        $select = ['*'];
        return $this->startConditions()
            ->select($select)
            ->where('login', $login)
            ->first();
    }
}
