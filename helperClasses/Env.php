<?php


namespace helperClasses;


use patterns\Singleton;

class Env extends Singleton
{
    protected array $env;

    protected function __construct()
    {
        parent::__construct();
        $this->env = json_decode(file_get_contents(ROOT_DIR . '/env.json'), true);
    }

    public function env($k) {
        return $this->env[$k] ?? null;
    }

    public static function get($k)
    {
        $self = self::getInstance();
        return $self->env($k);
    }
}
