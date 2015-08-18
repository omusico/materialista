<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionNearestTownDistance extends Model
{
    protected $table = 'nearest_town_distance';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_lands()
    {
        return $this->belongsToMany('App\RentLand');
    }

    public function sell_lands()
    {
        return $this->belongsToMany('App\SellLand');
    }
}