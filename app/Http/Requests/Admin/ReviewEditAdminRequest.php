<?php


namespace app\Http\Requests\Admin;

use app\Http\Requests\CoreRequest;
use Illuminate\Validation\Validation;

class ReviewEditAdminRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [
            'id.required' => 'id - Обязательное поле'
        ];
    }

    protected function getRules(): array
    {
        return [
            'id' => 'required'
        ];
    }
}