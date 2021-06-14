<?php


namespace app\Http\Requests\Rest\Comment;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class CommentPublishRestRequest extends CoreRequest
{

    protected function getMessages(): array
    {
        return [
            'required' => ':attribute - обязательное поле.'
        ];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('comment', 'id')]
        ];
    }
}
