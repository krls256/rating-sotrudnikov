<?php


namespace app\Http\Controllers\User;


use app\Repositories\Rest\CompanyRestRepository;
use app\Repositories\Rest\ReviewRestRepository;
use helperClasses\Auth;
use helperClasses\Request;

class IndexPageController extends UserController
{
    public function index(Request $request) : array {
        $companiesRepo = new CompanyRestRepository();
        $reviewsRepo = new ReviewRestRepository();
        $companies = $companiesRepo->getIndex([
            'orderBy' => CompanyRestRepository::ORDER_BY_DELTA_IN_INDEX,
            'auth' => Auth::isAuthedStatic()
        ]);
        $reviews = $reviewsRepo->getIndex([
            'limit' => 4,
            'orderByDesc' => 'review_date',
            'is_published' => 1,
            'with' => 'company:id,name,url'
        ]);

        $companiesSide = $this->getSideBarCompanies();

        return [
            'companies' => $companies,
            'reviews' => $reviews,
            'companiesSide' => $companiesSide
        ];
    }
}
