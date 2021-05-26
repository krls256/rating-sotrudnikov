<?php


namespace app\Http\Controllers\User;


use app\Http\Controllers\CoreController;
use Illuminate\Validation\Validator;

abstract class UserController extends CoreController
{

    public function __construct() { }


    protected function handleValidatorFailing(Validator $validator) {
        notFound();
    }
}