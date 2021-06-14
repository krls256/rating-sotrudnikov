<?php


namespace app\Http\Requests\Rest\Comment;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class CommentUpdateRestRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'date' => 'Поле :attribute должно быть датой.',
            'boolean' => 'Поле :attribute должно быть булевым значением.',
            'string' => 'Поле :attribute должно быть строкой.',
            'max' => 'Поле :attribute слишком большое.',
            'min' => 'Поле :attribute слишком маленькое.',
            'required' => 'Поле :attribute обязательное.'
        ];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('comment', 'id')],
            'fio' => 'nullable|string|min:1|max:190',
            'text' => 'nullable|string|min:1|max:65000',
            'review_id' => ['nullable', new ExistsRule('review', 'id')],
            'is_moderated' => 'nullable|boolean',
            'comment_date' => 'nullable|date'
        ];
    }


}
