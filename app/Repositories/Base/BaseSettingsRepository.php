<?php


namespace app\Repositories\Base;


use app\Repositories\CoreRepository;
use app\Models\Setting as Model;

class BaseSettingsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getSetting() : Model {
        $setting = $this->startConditions()
            ->first();
        return $setting;
    }
}