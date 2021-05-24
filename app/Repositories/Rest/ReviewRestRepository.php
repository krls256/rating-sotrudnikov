<?php


namespace app\Repositories\Rest;


use app\Repositories\Interfaces\IRestRepository;
use app\Models\Review;
use app\Repositories\CoreRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class ReviewRestRepository extends CoreRepository implements IRestRepository
{
    protected function getModelClass()
    {
        return Review::class;
    }

    public function getIndex(array $options) : Collection
    {
        $column = [
            'id', 'reviewer_name', 'reviewer_position',
            'is_positive', 'is_published', 'review_pluses',
            'review_minuses', 'review_date'];
        $res = $this->startConditions()
            ->select($column)
            ->get();
        return $res;
    }

    public function getPaginate(int $count, array $options) : Paginator
    {
        $column = [
            'id', 'reviewer_name', 'reviewer_position',
            'is_positive', 'is_published', 'review_pluses',
            'review_minuses', 'review_date'];
        $res = $this->startConditions()
            ->select($column)
            ->paginate($count);
        return $res;
    }

    public function getEdit(int $id) : Review
    {
        $column = [
            'id', 'reviewer_name', 'reviewer_position',
            'is_positive', 'is_published', 'review_pluses',
            'review_minuses', 'review_date', 'company_id'];
        $res = $this->startConditions()
            ->select($column)
            ->where('id', $id)
            ->first();
        return $res;
    }

    public function getShow(int $id) : Review
    {
        $column = '*';
        $res = $this->startConditions()
            ->select($column)
            ->where('id', $id)
            ->first();
        return $res;
    }

    public function getCreate(): Review
    {
        return $this->startConditions();
    }

    public function store(array $data) : Review
    {
        $res = $this->startConditions()
            ->create($data);
        return $res;
    }

    public function update(int $id, array $data) : int
    {
        $model = $this->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first();
        $res = $model->update($data);
        return $res;
    }
}