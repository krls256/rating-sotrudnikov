<?php


namespace app\Http\Requests\Rest\Company;


use app\Http\Requests\CoreRequest;
use app\Rules\ExistsRule;
use app\Rules\ImageRule;
use app\Rules\NumberMaskRule;

class CompanyUpdateRestRequest extends CoreRequest
{
    protected function getMessages(): array
    {
        return [
            'required' => ':attribute - поле обязательно',
            'string' => ':attribute - должно быть строкой',
            'numeric' => ':attribute - поле должно быть числом',
            'url' => ':attribute - поле должно быть ссылкой',
            'boolean' => ':attribute - поле должно быть логическим',
            'email' => ':attribute - поле должно быть почтой',
        ];
    }

    protected function getRules(): array
    {
        return [
            'id' => ['required', new ExistsRule('company', 'id')],
            'name' => ['required', 'string', 'min:3', 'max:55'],
            'phone' => ['required', new NumberMaskRule('+7 (000) 000-00-00')],
            'city' => ['required', 'numeric', 'min:1', 'max:1'],
            'address' => 'required|string|min:1|max:65000',
            'sity' => 'required|url',
            'description' => 'string|min:10|max:64000',
            'logo' => 'string|min:6|max:64000',
            'map' => 'string|min:1|max:55',
            'data' => 'numeric',
            'email' => 'string|email|min:1|max:100',
            'position' => 'numeric|min:0|max:20',
            'file' => [new ImageRule()],
            'fb' => 'string|url|max:100',
            'vk' => 'string|url|max:100',
            'tw' => 'string|url|max:100',
            'wa' => 'string|url|max:100',
            'vb' => 'string|url|max:100',
            'ok' => 'string|url|max:100',
            'tg' => 'string|url|max:100',
            'ins' => 'string|max:100',
            'inn' => 'string|max:20',
            'yb' => 'string|url|max:100',
            'url' => 'string|max:100',
            'imgMini' => 'string|max:100',
            'dev' => 'nullable|boolean',
            'email_hr' => 'nullable|email',
            'rating_hr' => 'boolean',
            'company_neorabote_link' => 'string|url|max:191',
            'company_otrude_link' => 'string|url|max:191',
            'company_antijob_link' => 'string|url|max:191',
            'company_otzyvy_rabota_link' => 'string|url|max:191',
            'company_rework_search_word' => 'string|max:191',
        ];
    }

}
