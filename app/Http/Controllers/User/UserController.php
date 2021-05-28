<?php


namespace app\Http\Controllers\User;


use app\Http\Controllers\CoreController;
use app\Http\ValidationHandlers\IValidationHandler;
use Illuminate\Validation\Validator;

abstract class UserController extends CoreController
{

    public function __construct(?IValidationHandler $validationHandler = null) {
        parent::__construct($validationHandler);
    }


    protected function handleValidatorFailing(Validator $validator) {
        notFound();
    }
}