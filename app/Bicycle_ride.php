<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bicycle_ride extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function bicycle_allowance()
{
    return $this->belongsTo('App\Bicycle_Allowance');
}
}
