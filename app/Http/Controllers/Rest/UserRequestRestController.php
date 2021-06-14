<?php


namespace app\Http\Controllers\Rest;


use app\Http\Requests\Rest\UserRequests\UserRequestsIndexRestRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Base\BaseCompaniesRepository;
use app\Repositories\Rest\UserRequestRestRepository;
use helperClasses\Request;

class UserRequestRestController extends RestController
{
    public function __construct(UserRequestRestRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($repository, $validationHandler);
    }

    public function index(Request $request)
    {
        $req = $request->all();
        $this->validate(UserRequestsIndexRestRequest::class, $req);
        $count = 25;
        $userRequests = $this->repository->getPaginate($count, $req);

        $companiesRepository = new BaseCompaniesRepository();
        $companies = $companiesRepository->getCompaniesNames();

        return [
            'userRequests' => $userRequests,
            'companies' => $companies
        ];
    }
}
