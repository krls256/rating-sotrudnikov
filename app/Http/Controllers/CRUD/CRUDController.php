<?php


namespace app\Http\Controllers\CRUD;


use app\Http\Controllers\CoreController;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Interfaces\IRestRepository;

abstract class CRUDController extends CoreController
{
    protected IRestRepository $repository;

    public function __construct(IRestRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($validationHandler);
        $this->repository = $repository;
    }
}
