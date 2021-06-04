<?php


namespace app\Models;


use app\Models\Aggregates\ReviewSource;
use app\Observers\ReviewObserver;

class Review extends CoreModel
{

    public function __construct(array $attributes = []) {
        $this->source = ReviewSource::getInstance();
        parent::__construct($attributes);
    }

    public $timestamps = false;
    protected $table = 'review';

    protected $fillable = [
        'reviewer_name', 'reviewer_position', 'is_positive', 'is_published', 'review_pluses', 'review_minuses',
        'review_date', 'company_id', 'is_first_screen_review', 'is_moderated'
    ];


    protected ?string $observerClass = ReviewObserver::class;

    protected ReviewSource $source;

    public function getSource(): ReviewSource
    {
        return $this->source;
    }

    public static function source() : ReviewSource {
        return ReviewSource::getInstance();
    }

    /**
     * ACCESSORS
     */

    public function getUserDateAttribute()
    {
        $date = \Carbon\Carbon::parse($this->review_date);
        $date->setTimezone('+3');
        return $date->isoFormat('YYYY-MM-DD hh:mm:ss');
    }

    protected string $defaultReviewerName = 'Не указано!';
    public function getReviewerNameNeverNullAttribute()
    {
        $name = $this->reviewer_name;
        return $name ? $name : $this->defaultReviewerName;
    }

    protected string $defaultReviewerPosition = 'Не указано!';
    public function getReviewerPositionNeverNullAttribute()
    {
        $position = $this->reviewer_position;
        return $position ? $position : $this->defaultReviewerPosition;
    }

    public function getSourceNameAttribute() {
        $src = $this->review_source;
        return $this->source->russianName($src);
    }

    protected string $defaultReviewerNameForUser = 'Неизвестный пользователь';
    public function getReviewerNameForUserAttribute()
    {
        $name = $this->reviewer_name;
        $position = $this->reviewer_position;
        return $name ? $name : ($position ? $position :$this->defaultReviewerNameForUser);
    }


    /**
     * RELATIONS
     */

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
