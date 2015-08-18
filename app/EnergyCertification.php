<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnergyCertification extends Model
{
    protected $table = 'energy_certification';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rent_apartment()
    {
        return $this->belongsTo('App\RentApartment');
    }

    public function sell_apartment()
    {
        return $this->belongsTo('App\SellApartment');
    }

    public function rent_country_house()
    {
        return $this->belongsTo('App\RentCountryHouse');
    }

    public function sell_country_house()
    {
        return $this->belongsTo('App\SellCountryHouse');
    }

    public function rent_house()
    {
        return $this->belongsTo('App\RentHouse');
    }

    public function sell_house()
    {
        return $this->belongsTo('App\SellHouse');
    }

    public function rent_office()
    {
        return $this->belongsTo('App\RentOffice');
    }

    public function sell_office()
    {
        return $this->belongsTo('App\SellOffice');
    }

    public function rent_business()
    {
        return $this->belongsTo('App\RentBusiness');
    }

    public function sell_business()
    {
        return $this->belongsTo('App\SellBusiness');
    }

}