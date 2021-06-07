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
        $res = $this
            ->startConditions()
            ->select('*')
            ->with('company')
            ->paginate($count, $column, 'page', $page);

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
