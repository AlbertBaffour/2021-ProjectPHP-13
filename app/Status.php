<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function bicycle_allowances()
    {
        return $this->hasMany('App\Bicycle_allowance');
    }
    public function laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance');
    }
    public function expense_allowances()
    {
        return $this->hasMany('App\Expense_allowance');
    }
}
