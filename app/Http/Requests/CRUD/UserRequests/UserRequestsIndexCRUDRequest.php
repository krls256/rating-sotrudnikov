<?php


namespace app\Http\Requests\CRUD\UserRequests;


use app\Http\Requests\CoreRequest;

class UserRequestsIndexCRUDRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [];
    }

    protected function getRules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
        ];
    }
}
