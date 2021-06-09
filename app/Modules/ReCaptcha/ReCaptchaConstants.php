<?php


namespace app\Modules\ReCaptcha;


use helperClasses\Env;

class ReCaptchaConstants
{
    public const RECAPTCHA_CHECK_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public static function GET_SECRET_KEY()
    {
        return Env::get('api_recaptcha');
    }

    public const USER_LOW_LIMIT = 0.5;
}
