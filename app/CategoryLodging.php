<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryLodging extends Model
{
    protected $table = 'category_lodging';
    protected $fillable = ['name'];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = ['created_at','updated_at'];

    public function lodgings()
    {
        return $this->belongsToMany('App\Lodging');
    }
}