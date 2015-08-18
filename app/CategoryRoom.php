<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryRoom extends Model
{
    protected $table = 'category_room';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function rooms()
    {
        return $this->belongsToMany('App\Room');
    }
}