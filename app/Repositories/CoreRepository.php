<?php


namespace app\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{
    /** @var model Model */
    protected $model;

    public
    function __construct()
    {
        $class =$this->getModelClass();
        $this->model = new $class;
    }

    abstract protected function getModelClass();

    protected function startConditions() {
        return clone $this->model;
    }
}