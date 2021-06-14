<?php


namespace app\Http\Requests\Rest\UserRequests;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;
use app\Rules\InArrayRule;

class UserRequestsIndexRestRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [];
    }

    protected function getRules(): array
    {
        return [
            'is_watched' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'sort_by' => ['nullable', new InArrayRule(['asc', 'desc'])],
            'company_id' => ['nullable', new ExistsRule('company', 'id')]
        ];
    }
}
