<?php


namespace app\Repositories\Rest;


use app\Repositories\CoreRepository;
use app\Models\Company;
use app\Repositories\Interfaces\IRestRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CompanyRestRepository extends CoreRepository implements IRestRepository
{
    public const ORDER_BY_DELTA_IN_INDEX = 'delta';

    protected function getModelClass()
    {
        return Company::class;
    }

    public function getIndex(array $options = []): Collection
    {
        $column = $options['column'] ?? '*';
        $orderBy = $options['orderBy'] ?? null;
        $orderByDesc = $options['orderByDesc'] ?? null;
        $orderByAsc = $options['orderByAsc'] ?? null;
        $limit = $options['limit'] ?? null;
        $req = $this->startConditions()
            ->select($column)
            ->withCount('reviewsPublishedPositive')
            ->withCount('reviewsPublishedNegative');

        if($limit !== null) {
            $req = $req->take($limit);
        }
        if($orderByDesc !== null) {
            $req = $req->orderBy($orderByDesc, 'desc');
        }

        if($orderByAsc !== null) {
            $req = $req->orderBy($orderByAsc, 'asc');
        }

        $companies = $req->get();

        if($orderBy === self::ORDER_BY_DELTA_IN_INDEX) {
            $companies = $companies->sortByDesc(function ($company) {
                return $company->reviews_published_positive_count - $company->reviews_published_negative_count;
            });
        }
        return $companies;
    }

    public function getPaginate(int $count, array $options): Paginator
    {
        $column = '*';
        $companies = $this->startConditions()
            ->select($column)
            ->paginate($count);
        return $companies;
    }

    public function getEdit(int $id): Model
    {
        $column = '*';
        $company = $this->startConditions()
            ->select($column)
            ->where('id', $id)
            ->first();
        return $company;
    }

    public function getShow(int $id): Model
    {
        $column = '*';
        $company = $this->startConditions()
            ->select($column)
            ->where('id', $id)
            ->first();
        return $company;
    }

    public function getCreate(): Model
    {
        return $this->startConditions();
    }

    public function store(array $data): Model
    {
        $res = $this->startConditions()
            ->create($data);
        return $res;
    }

    public function update(int $id, array $data): int
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
