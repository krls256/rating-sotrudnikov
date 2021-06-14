<?php


namespace app\Http\Controllers\Pack;


use app\Http\Controllers\CoreController;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Pack\IPackRepository;

abstract class PackController extends CoreController
{
    protected IPackRepository $repository;
    public function __construct(IPackRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($validationHandler);
        $this->repository = $repository;
    }
}
