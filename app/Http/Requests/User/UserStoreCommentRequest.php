<?php


namespace app\Http\Requests\User;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class UserStoreCommentRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'review_id.required' => 'Необходимо указать отзыв',

            'text.required' => 'Комментарий обязательное поле',
            'text.string' => 'Комментарий должен быть строкой',
            'text.min' => 'Минимальная длинна комментария :min символов',
            'text.max' => 'Максимальная длинна комментария :max символов',

            'fio.required' => 'Имя обязательное поле',
            'fio.string' => 'Имя должно быть строкой',
            'fio.min' => 'Минимальная длинна имени :min символов',
            'fio.max' => 'Максимальная длинна имени :max символов',

            'recaptcha_token.required' => 'Токен обязательное поле',
            'recaptcha_token.string' => 'Токен должен быть строкой'
        ];
    }

    protected function getRules(): array
    {
        return [
            'review_id' => ['required', new ExistsRule('review', 'id')],
            'text' => 'required|string|min:0|max:65000',
            'fio' => 'required|string|min:1|max:190',
            'recaptcha_token' => 'required|string',
        ];
    }

}
