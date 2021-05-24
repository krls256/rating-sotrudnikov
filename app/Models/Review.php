<?php


namespace app\Models;


use app\Models\EventHandlers\ReviewUpdatingEventHandler;
use app\Observers\ReviewObserver;

class Review extends CoreModel
{

    public $timestamps = false;
    protected $table = 'review';

    protected $fillable = [
        'reviewer_name', 'reviewer_position', 'is_positive', 'is_published', 'review_pluses', 'review_minuses', 'review_date',  'company_id'
    ];

    public function getUserDateAttribute() {
        $date = \Carbon\Carbon::parse($this->review_date);
        $date->setTimezone('+3');
        return $date->isoFormat('YYYY-MM-DD hh:mm:ss');
    }

    protected ?string $observerClass = ReviewObserver::class;
}