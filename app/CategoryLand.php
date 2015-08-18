<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryLand extends Model
{
    protected $table = 'category_land';
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