<?php


namespace app\Http\Controllers\User;


use app\Repositories\Rest\ReviewRestRepository;
use helperClasses\Request;

class AllReviewsPageController extends UserController
{
    public function index(Request $request, int $count = 10) : array {
        $req = $request->all();
        $reviewsRepo = new ReviewRestRepository();
        $companies = $this->getSideBarCompanies();
        $reviews = $reviewsRepo->getPaginate($count,
            array_merge($req, [
                'orderByDesc' => 'review_date',
                'is_published' => 1
                ]
            ));
        return [
            'companies' => $companies,
            'reviews' => $reviews,
        ];
    }
}
