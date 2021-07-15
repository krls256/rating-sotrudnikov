<?php


namespace app\Models;


class Company extends CoreModel
{
    public $timestamps = false;
    protected $table = 'company';
    protected $fillable = [
        'id', 'name', 'phone', 'city', 'position','address', 'sity', 'description', 'logo', 'map', 'email','data', 'fb',
        'vk', 'tw', 'wa', 'vb', 'ok', 'tg', 'ins', 'inn', 'yb', 'url', 'imgMini', 'dev', 'rating_hr', 'email_hr', 'company_neorabote_link', 'company_otrude_link', 'company_antijob_link', 'company_otzyvy_rabota_link', 'company_rework_search_word'
    ];


    /** Relations */
    public function userRequests() {
        return $this->hasMany(UserRequest::class);
    }

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

    public function comments() {
        return $this->hasManyThrough(Comment::class, Review::class);
    }

    /** Accessors */

    public function getProtocolAndSiteDomainAttribute() {
        if($this->sity) {
            $url = parse_url(trim($this->sity));
            if(isset($url['scheme']) && isset($url['host'])) {
                return $url['scheme'] . '://' . $url['host'];
            } else {
                return $this->sity;
            }
        }
        return '';
    }
}
