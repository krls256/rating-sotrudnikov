<?php


namespace app\Models;


class Setting extends CoreModel
{
    protected $table = 'setting';
    protected $fillable = ['name', 'title', 'description', 'header', 'h1', 'index_text', 'ya_metriks', 'google_metriks',
        'all_rev_title', 'all_rev_des', 'all_rev_h1', 'all_rev_text', 'contact_title', 'contact_des', 'ya_code', 'moderation'];
    public $timestamps = false;
}
