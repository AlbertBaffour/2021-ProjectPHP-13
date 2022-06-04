<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense_allowance extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function financial_officer()
    {
        return $this->belongsTo('App\User');
    }
    public function cost_center_manager()
    {
        return $this->belongsTo('App\User');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function cost_center()
    {
        return $this->belongsTo('App\Cost_center');
    }
    public function expense()
    {
        return $this->hasMany('App\Expense');
    }
}
