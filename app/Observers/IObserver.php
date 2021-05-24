<?php


namespace app\Observers;


use app\Models\CoreModel;

interface IObserver
{
    // Пока все события не нужны
//    public function booting(CoreModel $model) : bool;
//    public function booted(CoreModel $model) : bool;
    public function creating(CoreModel $model) : bool;
    public function created(CoreModel $model) : bool;
    public function updating(CoreModel $model) : bool;
    public function updated(CoreModel $model) : bool;
    public function deleting(CoreModel $model) : bool;
    public function deleted(CoreModel $model) : bool;
//    public function saving(CoreModel $model) : bool;
//    public function saved(CoreModel $model) : bool;
//    public function restoring(CoreModel $model) : bool;
//    public function restore(CoreModel $model) : bool;
}