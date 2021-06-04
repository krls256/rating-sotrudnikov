<?php


namespace app\Http\ValidationHandlers;


use Illuminate\Validation\Validator;

class ApiUserReviewStoreHandler implements IValidationHandler
{

    public function handle(Validator $validator)
    {
        echo json_encode(['status' => 'failure', 'errors' => $validator->errors()->all()]);
        stop();
    }
}
