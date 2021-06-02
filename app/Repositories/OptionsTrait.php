<?php


namespace app\Repositories;


trait OptionsTrait
{
    protected function useOptions($req, array $options) {
        $orderByDesc = $options['orderByDesc'] ?? null;
        $orderByAsc = $options['orderByAsc'] ?? null;
        $limit = $options['limit'] ?? null;
        $with = $options['with'] ?? null;


        if($orderByDesc !== null) {
            $req = $req->orderBy($orderByDesc, 'desc');
        }

        if($orderByAsc !== null) {
            $req = $req->orderBy($orderByAsc, 'asc');
        }

        if($limit !== null) {
            $req = $req->take($limit);
        }
        if($with !== null) {
            $req = $req->with($with);
        }

        return $req;

    }
}
