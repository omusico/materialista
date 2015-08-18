<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionOfficeDistribution extends Model
{
    protected $table = 'office_distribution';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_offices()
    {
        return $this->belongsToMany('App\RentOffice');
    }

    public function sell_offices()
    {
        return $this->belongsToMany('App\SellOffice');
    }
}