<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionCurrentTenantsGender extends Model
{
    protected $table = 'current_tenants_gender';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rooms()
    {
        return $this->belongsToMany('App\Room');
    }
}