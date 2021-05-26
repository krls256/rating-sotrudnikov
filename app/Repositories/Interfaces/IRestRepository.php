<?php


namespace app\Repositories\Interfaces;


use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRestRepository
{
    public function getIndex(array $options) : Collection;
    public function getPaginate(int $count, array $options): Paginator;
    public function getEdit(int $id) : Model;
    public function getShow(int $id) : Model;
    public function getCreate() : Model;
    public function store(array $data) : Model;
    public function update(int $id, array $data) : int;
    public function delete(int $id) : ?bool;
}