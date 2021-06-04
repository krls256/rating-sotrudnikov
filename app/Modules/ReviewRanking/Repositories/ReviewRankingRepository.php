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
        'review_pluses', 'review_minuses', 'review_date', 'company_id', 'review_hash'
    ];

    public function selectFirstPagePagination(int $company_id, int $perPage): Collection
    {
        $res = $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_first_screen_review', 1)
            ->where('is_published', 1)
            ->with(['comments' => function($query) {
                return $query->where('is_moderated', 1);
            }])
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->get();

        // если не хватает отзывов
        if($res->count() < $perPage) {
            $additional = $this->selectPagePagination($company_id, 1, $perPage - $res->count());
            $res = $res->merge($additional);
        }
        return $res;
    }

    protected function getFirstPageQuantity(int $company_id, int $perPage) {
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_first_screen_review', 1)
            ->where('is_published', 1)
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->get()
            ->count();
    }

    public function selectPagePagination(int $company_id, int $page, int $perPage): Collection
    {
        /** на случай если у компании недостаточно отзывов на первой странице
         * например: 5 положительных 4 отрицательных на первой странице 5 положительных 3 отрицательных, значит на
         * второй ден быть 1 отзыв.
         *
         */
        $additionalSkip = $perPage - $this->getFirstPageQuantity($company_id, $perPage);
        $skip = max(($page - 2) * $perPage, 0) + $additionalSkip;
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_first_screen_review', 0)
            ->where('is_published', 1)
            ->with(['comments' => function($query) {
                return $query->where('is_moderated', 1);
            }])
            ->orderBy('review_date', 'desc')
            ->take($perPage)
            ->skip($skip)
            ->get();
    }

    public function getPagesQuantity(int $company_id, int $perPage): int
    {
        $reviewsQuantity = $this->startConditions()
            ->select(['company_id'])
            ->where('is_published', 1)
            ->where('company_id', $company_id)
            ->count();
        return ceil($reviewsQuantity / $perPage);
    }

    public function getPositivePagePagination(int $company_id, int $page, int $perPage): Collection
    {
        $skip = ($page - 1) * $perPage;
        return $this->startConditions()
            ->select($this->paginationColumn)
            ->where('company_id', $company_id)
            ->where('is_positive', 1)
            ->where('is_published', 1)
            ->with(['comments' => function($query) {
                return $query->where('is_moderated', 1);
            }])
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
            ->where('is_published', 1)
            ->with(['comments' => function($query) {
                return $query->where('is_moderated', 1);
            }])
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
            ->where('is_published', 1)
            ->where('company_id', $company_id)
            ->count();

        return ceil($reviewsQuantity / $perPage);
    }

    public function getNegativeQuantity(int $company_id, int $perPage): int
    {
        $reviewsQuantity = $this->startConditions()
            ->select(['company_id', 'is_positive'])
            ->where('is_positive', 0)
            ->where('is_published', 1)
            ->where('company_id', $company_id)
            ->count();

        return ceil($reviewsQuantity / $perPage);
    }
}
