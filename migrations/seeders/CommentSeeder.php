<?php


namespace migrations\seeders;

use migrations\seeders\traits\DefaultSeederTrait;
use PDO;

require_once __DIR__ . '/../../config.php';

class CommentSeeder extends Seeder
{
    private $rows;
    private $model;
    private $reviews;

    public function __construct(PDO $PDO, $db, $rows, $model,  $reviews)
    {
        parent::__construct($PDO, $db);
        $this->model = new $model();
        $this->rows = $rows;
        $this->reviews = $reviews;
    }
    public function run()
    {
//        $reviewsFromDB = $this->getAddedReviews();
//        $DBReviewsMap = [];
//        foreach ($this->reviews as $review) {
//            dd($review);
//            $name = $review['reviewer_name'].$review['review_date'].$review['review_source'];
//            $key = $review['id'];
//
//            $DBReviewsMap[$key] =   $reviewsFromDB[$name];
//        }
//
//        foreach ($this->rows as $k => $v) {
//            $review_id = $this->rows[$k]['review'];
//            if(!isset($DBReviewsMap[$review_id])) {
//                unset($this->rows[$k]);
//                continue;
//            }
//            $this->rows[$k]['review'] = $DBReviewsMap[$review_id];
//        }
//
//        $this->defaultRun();
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
        return $this->getModel();
    }
}
