<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
     public function personnel_type()
    {
        return $this->belongsTo('App\Personnel_type');
    }
    public function cost_centers()
    {
        return $this->hasMany('App\Cost_center');
    }
    public function expense_allowances()
    {
        return $this->hasMany('App\Expense_allowance');
    }
    public function checked_expense_allowances()
    {
        return $this->hasMany('App\Expense_allowance','cost_center_manager_id');
    }
    public function paid_expense_allowances()
    {
        return $this->hasMany('App\Expense_allowance','financial_officer_id');
    }
    public function laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance');
    }
    public function checked_laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance','cost_center_manager_id');
    }
    public function paid_laptop_allowances()
    {
        return $this->hasMany('App\Laptop_allowance','financial_officer_id');
    }
    public function bicycle_allowances()
    {
        return $this->hasMany('App\Bicycle_allowance');
    }
    public function paid_bicycle_allowances()
    {
        return $this->hasMany('App\Bicycle_allowance','financial_officer_id');
    }
    public function laptops()
    {
        return $this->hasMany('App\Laptop');
    }

}
