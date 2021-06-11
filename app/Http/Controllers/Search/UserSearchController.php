<?php


namespace app\Http\Controllers\Search;


use app\Http\Controllers\CoreController;
use app\Http\Requests\Search\SearchCompaniesRequest;
use app\Repositories\Search\CompanySearchRepository;
use helperClasses\Request;

class UserSearchController extends CoreController
{
    public function searchCompanies(Request $request) {
        $this->validate(SearchCompaniesRequest::class, $request->all());
        $query = $request->get('search');
        $searchRepo = new CompanySearchRepository();
        return $searchRepo->searchInNameAndDescription($query);
    }
}
