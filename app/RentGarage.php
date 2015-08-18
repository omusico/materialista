<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentGarage extends Model
{
    protected $table = 'rent_garage';
    protected $fillable = ['ad_id', 'price', 'deposit', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'residential_area', 'garage_capacity_id', 'is_covered', 'has_automatic_door', 'has_lift', 'has_alarm', 'has_security_camera', 'has_security_guard', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function capacity()
    {
        return $this->hasOne('App\OptionGarageCapacity','garage_capacity_id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }
}