<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCountryHouse extends Model
{
    protected $table = 'category_country_house';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_country_house()
    {
        return $this->belongsToMany('App\RentCountryHouse');
    }

    public function sell_country_house()
    {
        return $this->belongsToMany('App\SellCountryHouse');
    }
}