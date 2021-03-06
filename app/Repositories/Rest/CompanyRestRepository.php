<?php


namespace app\Repositories\Rest;


use app\Models\Company;
use app\Repositories\CoreRepository;
use app\Repositories\Interfaces\IRestRepository;
use app\Repositories\OptionsTrait;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CompanyRestRepository extends CoreRepository implements IRestRepository
{
    use OptionsTrait;

    public const ORDER_BY_DELTA_IN_INDEX = 'delta';
    public const ORDER_BY_POSITION = 'position';

    protected function getModelClass()
    {
        return Company::class;
    }

    public function getIndex(array $options = []): Collection
    {
        $column = $options['column'] ?? '*';
        $orderBy = $options['orderBy'] ?? null;
        $limit = $options['limit'] ?? null;
        $auth = $options['auth'] ?? null;

        $req = $this->startConditions()
            ->select($column)
            ->withCount('reviewsPublishedPositive')
            ->withCount('reviewsPublishedNegative');
        $req = $this->useOptions($req, $options);

        if ($auth === false)
        {
            $req->where('dev', 0)
                ->orWhereNull('dev');
        }

        $companies = $req->get();

        if ($orderBy === self::ORDER_BY_DELTA_IN_INDEX)
        {
            $companies = $companies
                ->sortByDesc(
                    function ($company)
                    {
                        $difference = $company->reviews_published_positive_count - $company->reviews_published_negative_count;
                        $sum = $company->reviews_published_positive_count + $company->reviews_published_negative_count;
                        return $difference + $sum * 0.0001;
                    })
                ->values();
        } else if($orderBy === self::ORDER_BY_POSITION) {
            $companies = $companies->sortBy(function ($company) {
                if($company->position)
                    return $company->position;
                return 666;
            })->values();
        }
        if ($limit !== null)
        {
            $companies = $companies->take($limit);
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
