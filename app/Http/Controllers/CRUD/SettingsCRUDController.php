<?php


namespace app\Http\Controllers\CRUD;


use app\Http\Controllers\CoreController;
use app\Http\Requests\CRUD\Settings\SettingUpdateRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Rest\SettingsRestRepository;
use helperClasses\Request;

class SettingsCRUDController extends CoreController
{
    public function __construct(SettingsRestRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($validationHandler);
        $this->repository = $repository;
    }

    protected SettingsRestRepository $repository;

    public function update(Request $request)
    {
        $req = $request->all();
        $this->validate(SettingUpdateRequest::class, $req);
        $id = $req['id'];
        return $this->repository->update($id, $req);
    }
}
