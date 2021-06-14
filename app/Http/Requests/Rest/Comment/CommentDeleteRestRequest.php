<?php


namespace app\Http\Requests\Rest\Comment;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class CommentDeleteRestRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return ['required' => 'Поле :attribute - обязательно'];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('comment', 'id')]
        ];
    }

}
