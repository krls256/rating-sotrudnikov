<?php


namespace app\Http\Requests\Rest\Review;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class ReviewModerateRestRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [
            'id.required' => 'Идентификатор - обязательный'
        ];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('review', 'id')]
        ];
    }
}
