<?php


namespace app\Models;


use app\Observers\CommentObserver;

class Comment extends CoreModel
{
    protected $table = 'comment';
    protected $fillable = ['fio', 'text', 'review_id', 'is_moderated', 'comment_date'];
    public $timestamps = false;

    protected ?string $observerClass = CommentObserver::class;

    /**
     * ACCESSORS
     */

    public function getUserDateAttribute()
    {
        $date = \Carbon\Carbon::parse($this->comment_date);
        $date->setTimezone('+3');
        return $date->isoFormat('YYYY-MM-DD hh:mm:ss');
    }

    /**
     * RELATIONS
     */

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
