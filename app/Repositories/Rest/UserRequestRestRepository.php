<?php


namespace app\Repositories\Rest;


use app\Models\UserRequest;
use app\Repositories\CoreRepository;
use app\Repositories\Interfaces\IRestRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRequestRestRepository extends CoreRepository implements IRestRepository
{
    protected function getModelClass()
    {
        return UserRequest::class;
    }

    public function getIndex(array $options): Collection
    {
        return $this
            ->startConditions()
            ->select('*')
            ->get();
    }

    public function getPaginate(int $count, array $options): Paginator
    {
        $column = '*';
        $page = $options['page'] ?? 1;
        $sort_by = $options['sort_by'] ?? null;
        $is_watched = $options['is_watched'] ?? null;
        $company_id = $options['company_id'] ?? null;

        $req = $this
            ->startConditions()
            ->select('*')
            ->with('company');


        if($company_id !== null) {
            $req = $req->where('company_id', $company_id);
        }
        if($is_watched !== null) {
            $req = $req->where('is_watched', $is_watched);
        }
        if($sort_by !== null) {
            $req = $req->orderBy('id', $sort_by);
        }

        $res = $req->paginate($count, $column, 'page', $page);
        $ids = $res->map(function ($it) {return $it->id;})->toArray();
        $this->watch($ids);
        return $res;
    }

    public function getEdit(int $id): ?Model
    {
        return $this
            ->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first();
    }

    public function getShow(int $id): ?Model
    {
        return $this
            ->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first();
    }

    public function getCreate(): Model
    {
        return $this->startConditions();
    }

    public function store(array $data): Model
    {
        return $this->startConditions()
            ->create($data);
    }

    public function update(int $id, array $data): int
    {
        return $this->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first()
            ->update($data);
    }

    public function delete(int $id): ?bool
    {
        return $this->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first()
            ->delete();
    }

    protected function watch(array $ids) : int {
        return $this->startConditions()
            ->whereIn('id', $ids)
            ->update(['is_watched' => 1]);
    }

}
