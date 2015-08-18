<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rent_room';
    protected $fillable = ['ad_id', 'price', 'deposit', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'floor_number', 'is_last_floor', 'door', 'has_block', 'block', 'residential_area', 'category_room_id', 'area_room', 'n_people', 'n_bedrooms', 'n_bathrooms', 'current_tenants_gender_id', 'is_smoking_allowed', 'is_pet_allowed', 'min_current_tenants_age', 'max_current_tenants_age', 'has_elevator', 'has_furniture', 'has_builtin_closets', 'has_air_conditioning', 'has_internet', 'has_house_keeper', 'tenant_gender_id', 'tenant_occupation_id', 'tenant_sexual_orientation_id', 'tenant_min_stay_id', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function category()
    {
        return $this->hasOne('App\CategoryRoom','category_room_id');
    }

    public function tenant_min_stay()
    {
        return $this->hasOne('App\OptionTenantMinStay','tenant_min_stay_id');
    }

    public function current_tenants_gender()
    {
        return $this->hasOne('App\OptionCurrentTenantsGender','current_tenants_gender_id');
    }

    public function tenant_gender()
    {
        return $this->hasOne('App\OptionTenantGender','tenant_gender_id');
    }

    public function tenant_occupation()
    {
        return $this->hasOne('App\OptionTenantOccupation','tenant_occupation_id');
    }

    public function tenant_sexual_orientation()
    {
        return $this->hasOne('App\OptionTenantSexualOrientation','tenant_sexual_orientation_id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }
}