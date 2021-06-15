<?php


namespace app\Http\Controllers\Pack;

use app\Http\Requests\Pack\ReviewsPackRequest;
use app\Repositories\Base\BaseCompaniesRepository;
use helperClasses\Request;

class ReviewsPackController extends PackController
{


    public function storePack(Request $request) {
        $req = $request->all();
        $this->validate(ReviewsPackRequest::class, $req);
        $reviews = $req['reviews'];
        $this->prepareData($reviews);
        $res = $this->repository->insert($reviews);

        return $res;
    }

    private function prepareData(&$reviews) {
        $companiesRepo = new BaseCompaniesRepository();
        $companiesPreMap = $companiesRepo->getCompaniesNames();
        $companiesMap = [];

        foreach ($companiesPreMap as $company) {
            $id = $company->id;
            $name = $company->name;
            $companiesMap[$name] = $id;
        }

        for ($i = 0; $i < count($reviews); $i++) {
            $name = $reviews[$i]['company_name'];
            $reviews[$i]['company_id'] = $companiesMap[$name];
            unset($reviews[$i]['company_name']);
        }
    }


}
