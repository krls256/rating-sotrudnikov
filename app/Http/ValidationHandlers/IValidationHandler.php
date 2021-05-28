<?php


namespace app\Http\ValidationHandlers;


use Illuminate\Validation\Validator;

interface IValidationHandler
{
    public function handle(Validator $validator);
}