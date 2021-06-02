<?php


namespace migrations\seeders;

use app\Modules\ReviewRanking\ReviewRankingModule;
use migrations\seeders\traits\DefaultSeederTrait;
use PDO;

require_once __DIR__ . '/../../config.php';
require_once ROOT_DIR . '/migrations/seeders/Seeder.php';

class ReviewSeeder extends Seeder
{
    private $rows;
    private $table;
    private $companies;

    public function __construct(PDO $PDO, $db, $rows, $table, $companies)
    {
        parent::__construct($PDO, $db);
        $this->table = $table;
        $this->rows = $rows;
        $this->companies = $companies;
    }

    public function run()
    {

        $companiesFromDB = $this->getAddedCompanies();
        $DBCompaniesMap = [];

        foreach ($this->rows as $i => $review)
        {
            if ($review['is_positive'])
            {
                $this->rows[$i]['is_positive'] = 1;
            } else
            {
                $this->rows[$i]['is_positive'] = 0;
            }
            $this->rows[$i]['company_id'] = $companiesFromDB[$review['company_name']];

            $this->rows[$i]['review_pluses'] = str_replace("'", '`', $review['review_pluses']);
            $this->rows[$i]['review_minuses'] = str_replace("'", '`', $review['review_minuses']);
            unset($this->rows[$i]["company_name"]);
        }
        $perInsert = 300;
        $this->defaultRun($perInsert, function () use ($perInsert)
        {
            echo "$perInsert отзывов было добавлено в базу \n";
        });

        $module = new ReviewRankingModule();
        $module->reviseRanking();
    }

    public function getAddedCompanies()
    {
        $sql = "SELECT id, name FROM company";
        $req = $this->PDO
            ->prepare($sql);

        $req->execute();
        $res = $req->fetchAll();
        $companiesMap = [];

        foreach ($res as $company)
        {
            $k = $company['name'];
            $v = $company['id'];
            $companiesMap[$k] = $v;
        }
        return $companiesMap;
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
