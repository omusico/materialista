<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentHouse extends Model
{
    protected $table = 'rent_house';
    protected $fillable = ['ad_id', 'price', 'deposit', 'is_bank_agency','is_state_subsidized','is_new_development','is_new_development_finished','is_rent_to_own', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'residential_area', 'category_house_id', 'needs_restoration', 'area_constructed', 'area_usable', 'area_land', 'n_floors', 'n_bedrooms', 'n_bathrooms', 'has_equipped_kitchen', 'has_furniture', 'energy_certification_id', 'energy_performance', 'faces_north', 'faces_south', 'faces_east', 'faces_west', 'has_builtin_closets', 'has_air_conditioning', 'has_terrace', 'has_box_room', 'has_parking_space', 'has_fireplace', 'has_swimming_pool', 'has_garden', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function category()
    {
        return $this->hasOne('App\CategoryHouse','category_house_id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }

    public function energy_certification()
    {
        return $this->hasOne('App\EnergyCertification','energy_certification_id');
    }
}