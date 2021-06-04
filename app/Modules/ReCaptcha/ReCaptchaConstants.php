<?php


namespace app\Modules\ReCaptcha;


class ReCaptchaConstants
{
    public const RECAPTCHA_CHECK_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public static function GET_SECRET_KEY()
    {
        return '6LdPIwwbAAAAAAvI-Yb5trPyMJ8VYa3se-cj9qel';
    }

    public const USER_LOW_LIMIT = 0.5;
}
