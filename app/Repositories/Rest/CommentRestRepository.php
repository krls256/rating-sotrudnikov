<?php


namespace app\Repositories\Rest;


use app\Models\Comment;
use app\Repositories\Base\BaseCommentsRepository;
use app\Repositories\Base\BaseCompaniesRepository;
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

    protected function getCommentsIdsByCompanyId(int $id) {
        $companiesRepo = new BaseCompaniesRepository();
        $company = $companiesRepo->getWithComments($id);
        return $company
            ->comments
            ->map(function ($it) {return $it->id;})
            ->toArray();
    }

    public function getPaginate(int $count, array $options): Paginator
    {
        $column = '*';
        $page = $options['page'] ?? 1;
        $sort_by = $options['sort_by'] ?? null;
        $is_moderated = $options['is_moderated'] ?? null;
        $company_id = $options['company_id'] ?? null;



        $req = $this->startConditions()
            ->select($column)
            ->with(['review' => function($query) use ($company_id) {
                return $query->with('company:id,name');
            }]);

        if($company_id !== null) {
            $ids = $this->getCommentsIdsByCompanyId($company_id);
            $req = $req->whereIn('id', $ids);
        }
        if($is_moderated !== null) {
            $req = $req->where('is_moderated', $is_moderated);
        }
        if($sort_by !== null) {
            $req = $req->orderBy('id', $sort_by);
        }

        return $req->paginate($count, $column, 'page', $page);
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
