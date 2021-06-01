<?php

namespace app\Modules\Publishing\Repositories;

use app\Models\Company;
use app\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class CompanyPublishingRepository extends CoreRepository {
    protected function getModelClass()
    {
        return Company::class;
    }

    public function getCompaniesWithReviewsCounts() : Collection {
        $res = $this->startConditions()
            ->select('id', 'name')
            ->withCount(['reviewsPublishedPositive' => function($query) {
                $query->where('is_moderated', 1);
            }])
            ->withCount(['reviewsPublishedNegative' => function($query) {
                $query->where('is_moderated', 1);
            }])
            ->withCount(['reviewsNotPublishedPositive' => function($query) {
                $query->where('is_moderated', 1);
            }])
            ->withCount(['reviewsNotPublishedNegative' => function ($query)
            {
                $query->where('is_moderated', 1);
            }])
            ->get()
            ->keyBy('name');
        return $res;
    }


}
