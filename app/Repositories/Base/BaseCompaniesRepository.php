<?php


namespace app\Repositories\Base;


use app\Models\Company;
use app\Repositories\CoreRepository;
use Illuminate\Support\Collection;

class BaseCompaniesRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Company::class;
    }

    public function getCompaniesNames() : Collection {
        $column = ['id', 'name'];
        return $this->startConditions()
            ->select($column)
            ->toBase()
            ->get();
    }

}