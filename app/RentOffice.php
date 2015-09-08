<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentOffice extends Model
{
    protected $table = 'rent_office';
    protected $fillable = ['ad_id', 'price', 'deposit', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'floor_number', 'door', 'has_block', 'block', 'residential_area', 'needs_restoration', 'area_constructed', 'area_usable', 'area_min_for_sale', 'n_floors', 'has_offices_only', 'office_distribution_id', 'n_restrooms', 'has_bathrooms', 'has_bathrooms_inside', 'is_exterior', 'n_elevators', 'energy_certification_id', 'energy_performance', 'n_parking_spaces', 'has_steel_door', 'has_security_system', 'has_access_control', 'has_fire_detectors', 'has_fire_extinguishers', 'has_fire_sprinklers', 'has_fireproof_doors', 'has_emergency_lights', 'has_doorman', 'has_air_conditioning_preinstallation', 'has_air_conditioning', 'has_heating', 'has_hot_water', 'has_kitchen', 'has_archive', 'has_double_windows', 'has_suspended_ceiling', 'has_suspended_floor', 'is_handicapped_adapted', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function distribution()
    {
        return $this->hasOne('App\OptionOfficeDistribution','office_distribution_id');
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