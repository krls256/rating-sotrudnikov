<?php


namespace migrations\seeders;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/migrations/seeders/Seeder.php';
require_once ROOT_DIR . '/migrations/seeders/traits/DefaultSeederTrait.php';

use migrations\seeders\traits\DefaultSeederTrait;
use PDO;

class AdminSeeder extends Seeder
{
    private $rows;
    private $table;

    public function __construct(PDO $PDO, $db, $rows, $table)
    {
        parent::__construct($PDO, $db);
        $this->rows = $rows;
        $this->table = $table;
    }

    public function run()
    {
       $this->defaultRun();
    }


    // DEFAULT
    use DefaultSeederTrait;

    protected function getRows()
    {
        return $this->rows;
    }

    protected function getTable()
    {
        return $this->table;
    }

    protected function getPDO()
    {
        return $this->PDO;
    }

}