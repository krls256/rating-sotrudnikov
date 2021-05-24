<?php


namespace patterns;


class Singleton
{
    private static $instances = [];


    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup() { throw new \Error("Cannot __wakeup Singleton"); }

    public static function getInstance()
    {
        $childClass = static::class;
        if (!isset(self::$instances[$childClass])) {
            self::$instances[$childClass] = new static();
        }

        return self::$instances[$childClass];
    }
}