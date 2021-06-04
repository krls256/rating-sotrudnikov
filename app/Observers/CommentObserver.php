<?php


namespace app\Observers;


use app\Models\CoreModel;
use Carbon\Carbon;

class CommentObserver extends CoreObserver
{
    public function creating(CoreModel $model): bool
    {
        $date = $model->getAttribute('comment_date');
        if($date === null) {
            $model->setAttribute('comment_date', Carbon::now());
        }
        return true;
    }
}
