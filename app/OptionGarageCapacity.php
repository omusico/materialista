<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionGarageCapacity extends Model
{
    protected $table = 'garage_capacity';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_garage()
    {
        return $this->belongsToMany('App\RentGarage');
    }

    public function sell_garage()
    {
        return $this->belongsToMany('App\SellGarage');
    }
}