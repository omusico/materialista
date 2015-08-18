<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionTenantSexualOrientation extends Model
{
    protected $table = 'tenant_sexual_orientation';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rooms()
    {
        return $this->belongsToMany('App\Room');
    }
}