<?php


namespace migrations\seeders;
use migrations\seeders\traits\DefaultSeederTrait;
use PDO;

require_once __DIR__ . '/../../config.php';

class CompanySeeder extends Seeder
{

    private $rows;
    private $model;

    public function __construct(PDO $PDO,$db , $rows, $model)
    {
        parent::__construct($PDO, $db);
        $this->rows = $rows;
        $this->model = new $model();
    }

    public function run()
    {
        $this->getModel()->insert($this->getRows());
    }

    // DEFAULT
    use DefaultSeederTrait;

    protected function getRows()
    {
        return $this->rows;
    }

    protected function getPDO()
    {
        return $this->PDO;
    }

    protected function getModel()
    {
        return $this->model;
    }
}
