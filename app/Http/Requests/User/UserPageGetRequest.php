<?php


namespace app\Http\Requests\User;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class UserPageGetRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [
            'name.required' => 'Вы упустили имя компании'
        ];
    }

    protected function getRules(): array
    {
        return [
            'name'=>  ['required', new ExistsRule('company', 'url')]
        ];
    }
}