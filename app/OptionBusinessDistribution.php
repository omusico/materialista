<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionBusinessDistribution extends Model
{
    protected $table = 'business_distribution';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_businesses()
    {
        return $this->belongsToMany('App\RentBusiness');
    }

    public function sell_businesses()
    {
        return $this->belongsToMany('App\SellBusiness');
    }
}