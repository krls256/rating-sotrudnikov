<?php


namespace app\Repositories\Rest;


use app\Repositories\Interfaces\IRestRepository;
use app\Models\Review;
use app\Repositories\CoreRepository;
use app\Repositories\OptionsTrait;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class ReviewRestRepository extends CoreRepository implements IRestRepository
{
    use OptionsTrait;
    protected function getModelClass()
    {
        return Review::class;
    }

    public function getIndex(array $options = []) : Collection
    {
        $is_published = $options['is_published'] ?? null;
        $is_positive = $options['is_positive'] ?? null;
        $limit = $options['limit'] ?? null;

        $column = [
            'id', 'reviewer_name', 'reviewer_position',
            'is_positive', 'is_published', 'review_pluses',
            'review_minuses', 'review_date', 'company_id'];
        $req = $this->startConditions()
            ->select($column);
        $req = $this->useOptions($req, $options);

        if($is_published !== null) {
            $req = $req->where('is_published', $is_published);
        }
        if($is_positive !== null) {
            $req = $req->where('is_positive', $is_positive);
        }

        if($limit !== null) {
            $req = $req->take($limit);
        }

        return $req->get();
    }

    public function getPaginate(int $count, array $options = []) : Paginator
    {
        $company = $options['company_id'] ?? null;
        $is_published = $options['is_published'] ?? null;
        $is_positive = $options['is_positive'] ?? null;
        $is_moderated = $options['is_moderated'] ?? null;
        $review_source = $options['review_source'] ?? null;
        $limit = $options['limit'] ?? null;
        $orderByDesc = $options['orderByDesc'] ?? null;
        $orderByAsc = $options['orderByAsc'] ?? null;
        $page = $options['page'] ?? null;
        $sort = $options['sort_by'] ?? null;
        $column = [
            'id', 'reviewer_name', 'reviewer_position',
            'is_positive', 'is_published', 'is_moderated', 'review_pluses',
            'review_minuses', 'review_date', 'company_id', 'review_source'];
        $req = $this->startConditions()
            ->select($column)
            ->with('company:id,name');

        if($company !== null) {
            $req = $req->where('company_id', $company);
        }

        if($is_published !== null) {
            $req = $req->where('is_published', $is_published);
        }

        if($is_positive !== null) {
            $req = $req->where('is_positive', $is_positive);
        }

        if($is_moderated !== null) {
            $req = $req->where('is_moderated', $is_moderated);
        }

        if($review_source !== null) {
            $req = $req->where('review_source', $review_source);
        }

        if($limit !== null) {
            $req = $req->take($limit);
        }
        if($sort !== null) {
            $req = $req->orderBy('id', $sort);
        }
        if($orderByDesc !== null) {
            $req = $req->orderBy($orderByDesc, 'desc');
        }

        if($orderByAsc !== null) {
            $req = $req->orderBy($orderByAsc, 'asc');
        }

        $res = $req->paginate($count, $column, 'page', $page);

        return $res;
    }

    public function getEdit(int $id) : Review
    {
        $column = [
            'id', 'reviewer_name', 'reviewer_position',
            'is_positive', 'is_published', 'is_moderated',
            'review_pluses', 'review_minuses', 'review_date', 'company_id'];
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

    public function delete(int $id): ?bool
    {
        return $this->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first()
            ->delete();
    }
}
