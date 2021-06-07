<?php


namespace app\Http\Controllers\CRUD;


use app\Http\Requests\CRUD\UserRequests\UserRequestsIndexCRUDRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Rest\UserRequestRestRepository;
use helperClasses\Request;

class UserRequestCRUDController extends CRUDController
{
    public function __construct(UserRequestRestRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($repository, $validationHandler);
    }

    public function index(Request $request)
    {
        $req = $request->all();
        $this->validate(UserRequestsIndexCRUDRequest::class, $req);
        $count = 25;
        $userRequests = $this->repository->getPaginate($count, $req);

        return [
            'userRequests' => $userRequests
        ];
    }
}
