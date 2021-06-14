<?php


namespace app\Http\Requests\Rest\Review;

use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;
use Illuminate\Validation\Validation;

class ReviewEditRestRequest extends CoreRequest
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
            'id' => ['required', new ExistsRule('review', 'id')]
        ];
    }
}
