<?php

namespace database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\DatabaseManager;

class Database
{
    private $capsule;
    public function __construct($dbCredentials) {
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