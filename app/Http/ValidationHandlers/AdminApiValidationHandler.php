<?php


namespace app\Http\ValidationHandlers;


use Illuminate\Validation\Validator;

class AdminApiValidationHandler implements IValidationHandler
{
    public function handle(Validator $validator)
    {
        echo json_encode(['status' => 'failure', 'message' => $validator->errors()->all()]);
        exit();
    }

}