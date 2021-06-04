<?php


namespace app\Models;


class UserRequest extends CoreModel
{
    public $timestamps = false;
    protected $table = 'user_requests';
    protected $fillable = ['user_name', 'user_phone', 'company_id', 'is_watched'];


    /**
     * RELATIONS
     */

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
