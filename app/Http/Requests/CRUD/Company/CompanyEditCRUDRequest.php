<?php


namespace app\Http\Requests\CRUD\Company;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class CompanyEditCRUDRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return ['required' => ':attribute - обязательное поле'];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('company', 'id')]
        ];
    }

}
