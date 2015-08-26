<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeasonPrice extends Model
{
    protected $table = 'vacation_season_price';
    protected $fillable = ['n_season','from_date','to_date','p_one_night','p_weekend_night','p_one_week','p_half_month','p_one_month','p_extra_guest_per_night','n_min_nights','rent_vacation_id'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['from_date','to_date','created_at','updated_at'];

    public function rent_vacation()
    {
        return $this->belongsTo('App\Lodging');
    }
}