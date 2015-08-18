<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPic extends Model
{
    protected $table = 'ad_pic';
    protected $fillable = ['ad_id','filename'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }
}