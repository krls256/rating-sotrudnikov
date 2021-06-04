<?php


namespace app\Models;


class UserRequest extends CoreModel
{
    protected $table = 'user_requests';
    protected $fillable = ['user_name', 'user_phone', 'company_id'];


    /**
     * RELATIONS
     */

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
