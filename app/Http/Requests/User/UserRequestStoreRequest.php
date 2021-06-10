<?php


namespace app\Http\Requests\User;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;
use app\Rules\NumberMaskRule;

class UserRequestStoreRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'user_name.required' => 'Имя обязательное поле',
            'user_name.string' => 'Имя должно быть строкой',
            'user_name.min' => 'Минимальная длинна имени :min символов',
            'user_name.max' => 'Максимальная длинна имени :max символов',

            'company_id' => 'Компания обязательная',
            'user_phone' => 'Телефон обязательный',

            'recaptcha_token.required' => 'Токен обязательное поле',
            'recaptcha_token.string' => 'Токен должен быть строкой'
        ];
    }

    protected function getRules(): array
    {
        return [
            'company_id' => ['required', new ExistsRule('company','id')],
            'user_name' => 'required|string|min:1|max:190',
            'recaptcha_token' => 'required|string',
            'user_phone' => ['required', new NumberMaskRule('+7(000) 000-00-00')]
        ];
    }

}
