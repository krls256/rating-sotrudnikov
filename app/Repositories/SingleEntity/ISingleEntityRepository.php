<?php


namespace app\Repositories\SingleEntity;


use app\Models\CoreModel;

interface ISingleEntityRepository
{
    public function getBy(string $byColumn, $value, array $column = []) : CoreModel;
}