<?php


namespace app\Models;


class Company extends CoreModel
{
    public $timestamps = false;
    protected $table = 'company';


    /** Relations */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewsPublishedPositive()
    {
        return $this->reviews()->where('is_published', 1)->where('is_positive', 1);
    }


    public function reviewsPublishedNegative()
    {
        return $this->reviews()->where('is_published', 1)->where('is_positive', 0);
    }

    public function reviewsNotPublishedPositive()
    {
        return $this->reviews()->where('is_published', 0)->where('is_positive', 1);
    }

    public function reviewsNotPublishedNegative()
    {
        return $this->reviews()->where('is_published', 0)->where('is_positive', 0);
    }
}
