<?php


namespace migrations\seeders;

use PDO;

abstract class Seeder
{
    protected PDO $PDO;
    protected $db;

    public function __construct(PDO $PDO, $db) {
        $this->PDO = $PDO;
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getDB()
    {
        return $this->db;
    }

    abstract public function run();
}