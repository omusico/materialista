<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';
    protected $fillable = [];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function pics()
    {
        return $this->hasMany('App\AdPic','ad_id');
    }

    public function rent_vacation()
    {
        return $this->hasOne('App\Lodging','ad_id');
    }

    public function rent_room()
    {
        return $this->hasOne('App\Room','ad_id');
    }

    public function rent_land()
    {
        return $this->hasOne('App\RentLand','ad_id');
    }

    public function sell_land()
    {
        return $this->hasOne('App\SellLand','ad_id');
    }

    public function rent_business()
    {
        return $this->hasOne('App\RentBusiness','ad_id');
    }

    public function sell_business()
    {
        return $this->hasOne('App\SellBusiness','ad_id');
    }

    public function rent_office()
    {
        return $this->hasOne('App\RentOffice','ad_id');
    }

    public function sell_office()
    {
        return $this->hasOne('App\SellOffice','ad_id');
    }

    public function rent_house()
    {
        return $this->hasOne('App\RentHouse','ad_id');
    }

    public function sell_house()
    {
        return $this->hasOne('App\SellHouse','ad_id');
    }

    public function rent_country_house()
    {
        return $this->hasOne('App\RentCountryHouse','ad_id');
    }

    public function sell_country_house()
    {
        return $this->hasOne('App\SellCountryHouse','ad_id');
    }

}