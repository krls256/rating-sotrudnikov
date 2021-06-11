<?php


namespace app\Http\Requests\CRUD\Settings;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;

class SettingUpdateRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [

        ];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('setting', 'id')]
        ];
    }

}
