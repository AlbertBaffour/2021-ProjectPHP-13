<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function expense_allowance()
    {
        return $this->belongsTo('App\Expense_allowance');
    }
    public function proofs()
    {
        return $this->hasMany('App\Proof');
    }
}
