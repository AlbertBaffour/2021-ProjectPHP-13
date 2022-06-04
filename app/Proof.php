<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
    public function expense()
    {
        return $this->belongsTo('App\Expense');
    }
}
