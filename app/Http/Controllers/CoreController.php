<?php


namespace app\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

abstract class CoreController
{
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

        session()->set('error', $validator->errors()->all());
        back();
    }
}