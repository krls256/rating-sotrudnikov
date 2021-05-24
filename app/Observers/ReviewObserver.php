<?php


namespace app\Observers;


use app\Models\CoreModel;

class ReviewObserver extends CoreObserver
{
    //TODO: move to constants
    private $dafault_source = 'own';
    public function updating(CoreModel $model): bool
    {
        $hash = getHash($model->getAttribute('review_pluses'). $model->getAttribute('review_minuses'));
        $model->setAttribute('review_hash', $hash);
        return true;
    }

    public function creating(CoreModel $model): bool
    {
        $hash = getHash($model->getAttribute('review_pluses'). $model->getAttribute('review_minuses'));
        $model->setAttribute('review_hash', $hash);
        $src = $model->getAttribute('review_source');
        if(!$src) {
            $model->setAttribute('review_source', $this->dafault_source);
        }
        return true;
    }
}