<?php


namespace app\Http\Requests\User;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;
use app\Rules\NotPresentRule;

class UserStoreReviewRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'reviewer_name.required' => 'Имя обязательное поле',
            'reviewer_name.string' => 'Имя должно быть строкой',
            'reviewer_name.min' => 'Минимальная длинна имени :min символов',
            'reviewer_name.max' => 'Максимальная длинна имени :max символов',

            'reviewer_position.required' => 'Должность обязательное поле',
            'reviewer_position.string' => 'Должность должна быть строкой',
            'reviewer_position.min' => 'Минимальная длинна должности :min символов',
            'reviewer_position.max' => 'Максимальная длинна должности :max символов',

            'reviewer_pluses.required' => 'Плюсы обязательное поле',
            'reviewer_pluses.string' => 'Плюсы должны быть строкой',
            'reviewer_pluses.min' => 'Минимальная длинна плюсов :min символов',
            'reviewer_pluses.max' => 'Максимальная длинна плюсов :max символов',

            'reviewer_minuses.required' => 'Минусы обязательное поле',
            'reviewer_minuses.string' => 'Минусы должны быть строкой',
            'reviewer_minuses.min' => 'Минимальная длинна минусов :min символов',
            'reviewer_minuses.max' => 'Максимальная длинна минусов :max символов',

            'is_positive.required' => 'Нужно указать нравится ли вам компания',
            'is_positive.boolean' => 'Неверно указано нравится ли вам компания',

            'recaptcha_token.required' => 'Токен обязательное поле',
            'recaptcha_token.string' => 'Токен должен быть строкой'
        ];
    }

    protected function getRules(): array
    {
        return [
            'company_id' => ['required', new ExistsRule('company','id')],
            'reviewer_name' => 'required|string|min:1|max:190',
            'reviewer_position' => 'required|string|min:1|max:190',
            'review_pluses' => 'required|string|min:0|max:65000',
            'review_minuses' => 'required|string|min:0|max:65000',
            'is_positive' => 'required|boolean',
            'recaptcha_token' => 'required|string',
            'review_date' => [new NotPresentRule()]
        ];
    }

}
