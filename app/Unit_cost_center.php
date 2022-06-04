<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit_cost_center extends Model
{
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
    public function cost_center()
    {
        return $this->belongsTo('App\Cost_center');
    }
}
