<?php


namespace app\Http\Requests\Search;


use app\Http\Requests\CoreRequest;

class SearchCompaniesRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'required' => 'Поле :attribute обязательное',
            'string' => 'Поле :attribute обязательное',
        ];
    }

    protected function getRules(): array
    {
        return [
            'search' => 'required|string'
        ];
    }

}
