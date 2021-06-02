<?php


namespace app\Http\Requests\Admin;


use app\Http\Requests\CoreRequest;

class AuthRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'admin_login.required' => 'Логин - обязательное поле',
            'admin_password.required' => 'Пароль - обязательное поле',
        ];
    }

    protected function getRules(): array
    {
        return [
            'admin_login' => 'required',
            'admin_password' => 'required'
        ];
    }

}
