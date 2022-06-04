<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost_center extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance');
    }
    public function expense_allowances()
    {
        return $this->hasMany('App\Expense_allowance');
    }
    public function budgets()
    {
        return $this->hasMany('App\Budget');
    }
    public function cost_settings()
    {
        return $this->hasMany('App\Cost_setting');
    }
    public function bicycle_allowances()
    {
        return $this->hasMany('App\Bicycle_allowance');
    }
    public function unit_cost_centers()
    {
        return $this->hasMany('App\Unit_cost_center');
    }
}
