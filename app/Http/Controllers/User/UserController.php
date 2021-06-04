<?php


namespace app\Http\Controllers\User;


use app\Http\Controllers\CoreController;
use app\Http\ValidationHandlers\IValidationHandler;
use app\Repositories\Rest\CompanyRestRepository;
use Illuminate\Validation\Validator;

abstract class UserController extends CoreController
{

    public function __construct(?IValidationHandler $validationHandler = null) {
        parent::__construct($validationHandler);
    }


    protected function handleValidatorFailing(Validator $validator) {
        if($this->validationHandler === null)
            notFound();
        else
            $this->validationHandler->handle($validator);
    }

    protected function getSideBarCompanies() {
        $companiesRestRepo = new CompanyRestRepository();
        return $companiesRestRepo->getIndex([
            'limit' => 5,
            'orderBy' => CompanyRestRepository::ORDER_BY_DELTA_IN_INDEX
        ]);
    }
}
