<?php

namespace database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\DatabaseManager;
use patterns\Singleton;

class Database extends Singleton
{
    private $capsule;
    protected function __construct($dbCredentials) {
        parent::__construct();
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $dbCredentials['host'],
            'database'  => $dbCredentials['db'],
            'username'  => $dbCredentials['user'],
            'password'  => $dbCredentials['pass'],
            'charset'   => $dbCredentials['charset'],
            'collation' => $dbCredentials['collation'],
            'prefix'    => '',
        ]);
        $capsule->bootEloquent();

        $this->capsule = $capsule;
    }

    public function getPDO() {
        return $this->capsule->getConnection()->getPdo();
    }

    public function getDB() : DatabaseManager  {
        return $this->capsule->getDatabaseManager();
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
}