<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lodging extends Model
{
    protected $table = 'rent_vacation';
    protected $fillable = ['ad_id', 'lat', 'lng', 'formatted_address', 'street_number', 'route', 'locality', 'admin_area_lvl2', 'admin_area_lvl1', 'country', 'postal_code', 'hide_address', 'floor_number', 'is_last_floor', 'door', 'has_block', 'block', 'residential_area', 'surroundings_id', 'category_lodging_id', 'has_multiple_lodgings', 'area_total', 'area_garden', 'area_terrace', 'is_american_kitchen', 'distance_to_beach', 'distance_to_town_center', 'distance_to_ski_area', 'distance_to_golf_course', 'distance_to_airport', 'distance_to_supermarket', 'distance_to_river_or_lake', 'distance_to_marina', 'distance_to_horse_riding_area', 'distance_to_scuba_diving_area', 'distance_to_train_station', 'distance_to_bus_station', 'distance_to_hospital', 'distance_to_hiking_area', 'n_double_bedroom', 'n_two_beds_room', 'n_single_bed_room', 'n_three_beds_room', 'n_four_beds_room', 'n_sofa_bed', 'n_double_sofa_bed', 'n_extra_bed', 'min_capacity', 'max_capacity', 'n_days_before', 'payment_day_id', 'has_booking', 'booking', 'has_deposit', 'deposit', 'has_cleaning', 'cleaning', 'has_included_towels', 'has_included_expenses', 'accepts_cash', 'accepts_transfer', 'accepts_credit_card', 'accepts_paypal', 'accepts_check', 'accepts_western_union', 'accepts_money_gram', 'has_barbecue', 'has_terrace', 'has_private_swimming_pool', 'has_shared_swimming_pool', 'has_indoor_swimming_pool', 'has_private_garden', 'has_shared_garden', 'has_furnished_garden', 'has_parking_space', 'has_playground', 'has_mountain_sights', 'has_sea_sights', 'has_fireplace', 'has_air_conditioning', 'has_jacuzzi', 'has_tv', 'has_cable_tv', 'has_internet', 'has_heating', 'has_fan', 'has_cradle', 'has_hairdryer', 'has_dishwasher', 'has_fridge', 'has_oven', 'has_microwave', 'has_coffee_maker', 'has_dryer', 'has_washer', 'has_iron', 'is_smoking_allowed', 'is_pet_allowed', 'has_elevator', 'is_car_recommended', 'is_handicapped_adapted', 'is_out_town_center', 'is_isolated', 'is_nudist_area', 'is_bar_area', 'is_gayfriendly_area', 'is_family_tourism_area', 'is_luxury_area', 'is_charming', 'has_bicycle_rental', 'has_car_rental', 'has_adventure_activities', 'has_kindergarten', 'has_sauna', 'has_tennis_court', 'has_paddle_court', 'has_gym', 'description'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function payment_day()
    {
        return $this->hasOne('App\OptionPaymentDay','payment_day_id');
    }

    public function category()
    {
        return $this->hasOne('App\CategoryLodging','category_lodging_id');
    }

    public function surroundings()
    {
        return $this->hasOne('App\OptionSurroundings','surroundings_id');
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }

    public function prices()
    {
        return $this->hasMany('App\SeasonPrice','rent_vacation_id');
    }
}