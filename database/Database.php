<?php

namespace database;

use helperClasses\Env;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\DatabaseManager;
use patterns\Singleton;

class Database extends Singleton
{
    private $capsule;
    private $DB;
    protected function __construct() {
        parent::__construct();
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      =>  Env::get('db_host'),
            'database'  =>  Env::get('db_name'),
            'username'  =>  Env::get('db_user'),
            'password'  =>  Env::get('db_pass'),
            'charset'   =>  Env::get('db_charset'),
            'collation' =>  Env::get('db_collation'),
            'prefix'    =>  '',
        ]);
        $capsule->bootEloquent();

        $this->capsule = $capsule;
        $this->DB = $this->capsule->getDatabaseManager();
    }

    public function getPDO() {
        return $this->capsule->getConnection()->getPdo();
    }

    public function &getDB() : DatabaseManager  {
        return $this->DB;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}
