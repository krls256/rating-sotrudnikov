<?php


namespace app\Http\Controllers\User;


use app\Repositories\Rest\ReviewRestRepository;
use helperClasses\Auth;
use helperClasses\Request;

class ContactsPageController extends UserController
{
    public function index(Request $request) : array {
        $companies = $this->getSideBarCompanies();
        $reviewsRepo = new ReviewRestRepository();
        $reviews = $reviewsRepo->getIndex([
            'limit' => 4,
            'orderByDesc' => 'review_date',
            'is_published' => 1,
            'with' => 'company:id,name,url',
            'auth' => Auth::isAuthedStatic()
        ]);
        return [
            'companies' => $companies,
            'reviews' => $reviews
        ];
    }
}
