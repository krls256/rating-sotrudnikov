<?php


namespace app\Modules\ReviewRanking\Repositories;


use app\Models\Review as Model;
use app\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Collection;

class ReviewRankingRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAllReviewsOrderByDate(): Collection
    {
        $column = ['id', 'is_positive', 'is_published',
            'review_date', 'company_id'];
        $collection = $this->startConditions()
            ->select($column)
            ->where('is_published', 1)
            ->orderBy('review_date', 'desc')
            ->get();

        return $collection;
    }

    public function resetReviewsFirstScreen(): int
    {
        return $this->startConditions()
            ->select('is_first_screen_review')
            ->update(['is_first_screen_review' => 0]);
    }

    public function setReviewsFirstScreen(array $ids): int
    {
        return $this->startConditions()
            ->whereIn('id', $ids)
            ->update(['is_first_screen_review' => 1]);
    }

    protected $paginationColumn = [
        'id', 'reviewer_name', 'reviewer_position',
        'is_positive', 'is_published', 'is_first_screen_review',
        'review_pluses', 'review_minuses', 'review_date', 'company_id'
    ];

    public function selectFirstPagePagination(int $company_id, int $perPage): Collection
    {
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_first_screen_review', 1)
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->get();
    }

    public function selectPagePagination(int $company_id, int $page, int $perPage): Collection
    {
        $skip = ($page - 2) * $perPage;
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_first_screen_review', 0)
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->skip($skip)
            ->get();
    }

    public function getPagesQuantity(int $company_id, int $perPage): int
    {
        $reviewsQuantity = $this->startConditions()
            ->select(['company_id', 'is_first_screen_review'])
            ->where('is_first_screen_review', 0)
            ->where('company_id', $company_id)
            ->count();

        return ceil($reviewsQuantity / $perPage) + 1; // plus first screen
    }

    public function getPositivePagePagination(int $company_id, int $page, int $perPage): Collection
    {
        $skip = ($page - 1) * $perPage;
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_positive', 1)
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->skip($skip)
            ->get();
    }

    public function getNegativePagePagination(int $company_id, int $page, int $perPage): Collection
    {
        $skip = ($page - 1) * $perPage;
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_positive', 0)
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->skip($skip)
            ->get();
    }

    public function getPositivePagesQuantity(int $company_id, int $perPage): int
    {
        $reviewsQuantity = $this->startConditions()
            ->select(['company_id', 'is_positive'])
            ->where('is_positive', 1)
            ->where('company_id', $company_id)
            ->count();

        return ceil($reviewsQuantity / $perPage);
    }

    public function getNegativeQuantity(int $company_id, int $perPage): int
    {
        $reviewsQuantity = $this->startConditions()
            ->select(['company_id', 'is_positive'])
            ->where('is_positive', 0)
            ->where('company_id', $company_id)
            ->count();

        return ceil($reviewsQuantity / $perPage);
    }
}