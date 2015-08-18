<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionSurroundings extends Model
{
    protected $table = 'surroundings';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function lodgings()
    {
        return $this->belongsToMany('App\Lodging');
    }
}
