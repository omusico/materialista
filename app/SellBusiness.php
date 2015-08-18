<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellBusiness extends Model
{
    protected $table = 'sell_business';
    protected $fillable = ['ad_id', 'price', 'community_cost', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'floor_number', 'door', 'has_block', 'block', 'residential_area', 'category_business_id', 'needs_restoration', 'area_constructed', 'area_usable', 'business_distribution_id', 'business_facade_id', 'n_shop_windows', 'business_location_id', 'n_floors', 'n_restrooms', 'last_activity', 'energy_certification_id', 'energy_performance', 'has_archive', 'has_smoke_extractor', 'has_fully_equipped_kitchen', 'has_steel_door', 'has_alarm', 'has_air_conditioning', 'has_heating', 'has_security_camera', 'is_corner_located', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function garage_capacity()
    {
        return $this->hasOne('App\OptionGarageCapacity','garage_capacity_id');
    }

    public function location()
    {
        return $this->hasOne('App\OptionBusinessLocation','business_location_id');
    }

    public function facade_size()
    {
        return $this->hasOne('App\OptionBusinessFacade','business_facade_id');
    }

    public function distribution()
    {
        return $this->hasOne('App\OptionBusinessDistribution','business_distribution_id');
    }

    public function category()
    {
        return $this->hasOne('App\CategoryBusiness','category_business_id');
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