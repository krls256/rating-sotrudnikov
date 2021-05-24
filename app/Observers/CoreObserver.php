<?php


namespace app\Observers;


use app\Models\CoreModel;

abstract class CoreObserver implements IObserver
{

    public function updating(CoreModel $model): bool
    {
        return true;
    }

    public function updated(CoreModel $model): bool
    {
        return true;
    }

    public function deleting(CoreModel $model): bool
    {
        return true;
    }

    public function deleted(CoreModel $model): bool
    {
        return true;
    }

    public function creating(CoreModel $model): bool
    {
        return true;
    }

    public function created(CoreModel $model): bool
    {
        return true;
    }

}