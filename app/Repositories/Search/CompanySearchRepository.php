<?php


namespace app\Repositories\Search;


use app\Models\Company;
use app\Repositories\CoreRepository;

class CompanySearchRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Company::class;
    }

    public function searchInNameAndDescription($query) {
        $column = ['id', 'name', 'description', 'dev', 'url'];
        return $this->startConditions()
            ->select($column)
            ->where(function ($q) {
                $q->where('dev', 0)->orWhereNull('dev');
            })
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->toBase()
            ->get();
    }

}
