<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function cost_center()
    {
        return $this->belongsTo('App\Cost_center');
    }
}
