<?php


namespace app\Modules\ReviewRanking\Repositories;


use app\Modules\ReviewRanking\ReviewRankingConstants;
use app\Repositories\CoreRepository;
use app\Models\Company;
use Illuminate\Support\Collection;

class CompaniesRankingRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Company::class;
    }

    public function getSpecialCompanyId() : ?int {
        $res = $this->startConditions()
            ->select(['id'])
            ->where('name', ReviewRankingConstants::SPECIAL_COMPANY_NAME)
            ->first();

        if($res) {
            return (int) $res->id;
        }
        return $res;
    }

}