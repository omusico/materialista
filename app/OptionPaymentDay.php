<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionPaymentDay extends Model
{
    protected $table = 'payment_day';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function lodgings()
    {
        return $this->belongsToMany('App\Lodging');
    }
}