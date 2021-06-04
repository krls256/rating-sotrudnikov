<?php


namespace app\Repositories\Rest;


use app\Models\Comment;
use app\Repositories\CoreRepository;
use app\Repositories\Interfaces\IRestRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CommentRestRepository extends CoreRepository implements IRestRepository
{
    protected function getModelClass()
    {
        return Comment::class;
    }

    public function getIndex(array $options): Collection
    {
        return $this->startConditions()
            ->select('*')
            ->get();
    }

    public function getPaginate(int $count, array $options): Paginator
    {
        return $this->startConditions()
            ->select('*')
            ->paginate($count);
    }

    public function getEdit(int $id): ?Model
    {
        return $this->startConditions()
            ->select('*')
            ->where('id', $id)
            ->first();
    }

    public function getShow(int $id): Model
    {
        return $this->startConditions()
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
