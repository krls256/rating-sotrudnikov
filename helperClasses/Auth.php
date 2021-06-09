<?php


namespace helperClasses;


use patterns\Singleton;

class Auth extends Singleton
{
    public const LOGIN_FIELD = 'admin_login';
    public const PASSWORD_FIELD = 'admin_password';

    protected $isAuthed = false;

    public function isAuthed() {
        return $this->isAuthed;
    }

    public function auth() {
        $this->isAuthed = true;
    }

    public static function isAuthedStatic() {
        return self::getInstance()->isAuthed();
    }
}
