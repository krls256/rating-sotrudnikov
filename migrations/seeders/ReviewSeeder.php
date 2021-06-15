<?php


namespace migrations\seeders;

use app\Models\Review;
use app\Modules\ReviewRanking\ReviewRankingModule;
use app\Repositories\Base\BaseCompaniesRepository;
use migrations\seeders\traits\DefaultSeederTrait;
use PDO;

require_once __DIR__ . '/../../config.php';

class ReviewSeeder extends Seeder
{
    private $rows;
    private $model;
    private $companies;

    public function __construct(PDO $PDO, $db, $rows, $model, $companies)
    {
        parent::__construct($PDO, $db);
        $this->model = new $model();
        $this->rows = $rows;
        $this->companies = $companies;
    }

    public function run()
    {
        $companiesFromDB = $this->getAddedCompanies();
        $seedCompanies = collect($this->companies)->keyBy('id');

        foreach ($this->rows as $i => $review)
        {
            $review['company_name'] = $seedCompanies[$review['company_id']]['name'];
            if ($review['is_positive'])
                $this->rows[$i]['is_positive'] = 1;
            else
                $this->rows[$i]['is_positive'] = 0;

            $this->rows[$i]['company_id'] = $companiesFromDB[$review['company_name']];
            $this->rows[$i]['review_hash'] = Review::getHash($review['review_pluses'], $review['review_minuses']);
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
        $companiesRepo = new BaseCompaniesRepository();
        $res = $companiesRepo->getCompaniesNames()->toArray();
        $companiesMap = [];

        foreach ($res as $company)
        {
            $k = $company->name;
            $v = $company->id;
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


    protected function getPDO()
    {
        return $this->PDO;
    }

    protected function getModel()
    {
        return $this->model;
    }
}
