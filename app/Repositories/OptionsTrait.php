<?php


namespace app\Repositories;


trait OptionsTrait
{
    protected function useOptions($req, array $options) {
        $orderByDesc = $options['orderByDesc'] ?? null;
        $orderByAsc = $options['orderByAsc'] ?? null;
        $with = $options['with'] ?? null;


        if($orderByDesc !== null) {
            $req = $req->orderBy($orderByDesc, 'desc');
        }

        if($orderByAsc !== null) {
            $req = $req->orderBy($orderByAsc, 'asc');
        }


        if($with !== null) {
            $req = $req->with($with);
        }

        return $req;

    }
}
