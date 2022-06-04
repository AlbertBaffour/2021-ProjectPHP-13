<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost_setting extends Model
{
    public function laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance');
    }public function bicycle_allowances()
    {
        return $this->hasMany('App\Bicycle_allowance');
    }
    public function cost_center()
    {
        return $this->belongsTo('App\Cost_center');
    }
}
