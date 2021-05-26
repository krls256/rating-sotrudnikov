<?php


namespace app\Repositories\SingleEntity;


use app\Models\Company;
use app\Repositories\CoreRepository;

class CompanySingleEntityRepository extends CoreRepository implements ISingleEntityRepository
{
    public function getBy(string $byColumn, $value, array $column = []): Company
    {
        if ($column === [])
            $realCol = '*';
        else
            $realCol = $column;

        return $this->startConditions()
            ->select($realCol)
            ->where($byColumn, $value)
            ->first();
    }


    protected function getModelClass()
    {
        return Company::class;
    }
}