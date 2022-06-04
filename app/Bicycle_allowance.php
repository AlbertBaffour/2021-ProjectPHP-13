<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bicycle_allowance extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function financial_officer()
    {
        return $this->belongsTo('App\User');
    }
    public function cost_setting()
    {
        return $this->belongsTo('App\Cost_setting');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function cost_center()
    {
        return $this->belongsTo('App/Cost_center');
    }
    public function bicycle_rides()
    {
        return $this->hasMany('App\Bicycle_ride');
    }
}
