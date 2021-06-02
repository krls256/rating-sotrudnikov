<?php


namespace app\Observers;


use app\Models\CoreModel;
use app\Modules\Publishing\PublishingConstants;
use app\Modules\Publishing\PublishingModule;
use app\Modules\ReviewRanking\ReviewRankingModule;

class ReviewObserver extends CoreObserver
{
    protected $needToPublish = false;

    //TODO: move to constants
    private $dafault_source = 'own';

    public function updating(CoreModel $model): bool
    {
        $hash = getHash($model->getAttribute('review_pluses') . $model->getAttribute('review_minuses'));
        $model->setAttribute('review_hash', $hash);
        if ($model->isDirty('is_moderated'))
        {
            $this->needToPublish = true;
        }
        if ($model->isDirty('is_moderated') && ((int)$model->getAttribute('is_moderated') === 0))
        {
            $model->setAttribute('is_published', 0);
        }
        return true;
    }

    public function created(CoreModel $model): bool
    {
        $rankingModule = new ReviewRankingModule();
        $rankingModule->reviseRanking();
        return true;
    }

    public function updated(CoreModel $model): bool
    {
        $rankingModule = new ReviewRankingModule();
        $rankingModule->reviseRanking();
        if ($this->needToPublish)
        {
            $publishingModule = new PublishingModule();
            $publishingModule->normalize(PublishingConstants::DELTA_ORIENTED_INDEX);
        }
        return true;
    }

    public function creating(CoreModel $model): bool
    {
        $hash = getHash($model->getAttribute('review_pluses') . $model->getAttribute('review_minuses'));
        $model->setAttribute('review_hash', $hash);
        $src = $model->getAttribute('review_source');
        if (!$src)
        {
            $model->setAttribute('review_source', $this->dafault_source);
        }
        return true;
    }
}
