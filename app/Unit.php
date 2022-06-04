<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
    public function unit_cost_centers()
    {
        return $this->hasMany('App\Unit_cost_center');
    }
}
