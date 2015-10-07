<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constants extends Model
{
    protected $table = 'global_cms_constants';
    protected $fillable = ['n_ad_seeds', 'starting_year', 'dev_version', 'dev_email', 'search_distance', 'company_name', 'company_description', 'public_logo', 'dashboard_logo', 'company_phone', 'company_email', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];
}