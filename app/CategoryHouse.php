<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryHouse extends Model
{
    protected $table = 'category_house';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_house()
    {
        return $this->belongsToMany('App\RentHouse');
    }

    public function sell_house()
    {
        return $this->belongsToMany('App\SellHouse');
    }
}