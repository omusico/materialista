<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentLand extends Model
{
    protected $table = 'rent_land';
    protected $fillable = ['ad_id', 'price', 'deposit', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'residential_area', 'category_land_id', 'area_total', 'area_building_land', 'area_min_for_sale', 'is_classified_residential_block', 'is_classified_residential_house', 'is_classified_office', 'is_classified_commercial', 'is_classified_hotel', 'is_classified_industrial', 'is_classified_public_service', 'is_classified_others', 'max_floors_allowed', 'has_road_access', 'nearest_town_distance_id', 'has_water', 'has_electricity', 'has_sewer_system', 'has_natural_gas', 'has_street_lighting', 'has_sidewalks', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function nearest_town_distance()
    {
        return $this->hasOne('App\OptionNearestTownDistance','nearest_town_distance_id');
    }

    public function category()
    {
        return $this->hasOne('App\CategoryLand','category_land_id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }
}