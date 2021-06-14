<?php


namespace app\Http\Controllers\Rest;


use app\Http\Requests\Rest\Settings\SettingUpdateRestRequest;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Rest\SettingsRestRepository;
use helperClasses\Request;

class SettingsRestController extends RestController
{
    public function __construct(SettingsRestRepository $repository, ?IValidationHandler $validationHandler = null)
    {
        parent::__construct($repository, $validationHandler);
    }

    public function update(Request $request)
    {
        $req = $request->all();
        $this->validate(SettingUpdateRestRequest::class, $req);
        $id = $req['id'];
        return $this->repository->update($id, $req);
    }
}
