<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance');
    }
}
