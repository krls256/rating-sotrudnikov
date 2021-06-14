<?php


namespace app\Http\Controllers\Rest;


use app\Http\Controllers\CoreController;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Interfaces\IRestRepository;

abstract class RestController extends CoreController
{
    protected IRestRepository $repository;

    public function __construct(IRestRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($validationHandler);
        $this->repository = $repository;
    }
}
