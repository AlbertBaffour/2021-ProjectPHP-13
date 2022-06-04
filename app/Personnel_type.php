<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel_type extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
