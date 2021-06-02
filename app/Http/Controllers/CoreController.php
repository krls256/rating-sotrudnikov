<?php


namespace app\Http\Controllers;


use app\Http\ValidationHandlers\IValidationHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

abstract class CoreController
{
    protected ?IValidationHandler $validationHandler;

    public function __construct(?IValidationHandler $validationHandler = null) {
        $this->validationHandler = $validationHandler;
    }

    protected function validate(string $validatorClass, array $validationData = null) {
        $validator = new $validatorClass();
        if($validationData !== null) {
            $validated = $validator->validate($validationData);
        } else {
            $validated = $validator->validate(Request::capture()->all());
        }
        if($validated->fails()) {

            $this->handleValidatorFailing($validated);
        }
    }

    protected function handleValidatorFailing(Validator $validator) {
        if($this->validationHandler) {
            $this->validationHandler->handle($validator);
        } else {
            session()->set('error', $validator->errors()->all());
            back();
        }

    }
}
