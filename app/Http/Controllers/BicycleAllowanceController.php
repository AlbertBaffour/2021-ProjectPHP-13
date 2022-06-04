<?php

namespace App\Http\Controllers;

use App\Bicycle_allowance;
use App\Bicycle_ride;
use Illuminate\Http\Request;

class BicycleAllowanceController extends Controller
{
    public function create()
    {
        return view('bicycle_allowance.create');
    }
    public function  store(Request $request) {
        // Validate $request
        $this->validate($request,[
             'rideDate'=>'required|Date'
        ]);
        $bicycle_allowance = new Bicycle_allowance();
        $bicycle_allowance->user_id = auth()->user()->id;
        $bicycle_allowance->submission_date=now();
        $bicycle_allowance->payment_date=now();
        $bicycle_allowance->amount_per_km = auth()->user()->total_km;
        $bicycle_allowance->cost_center_id = '1';
        $bicycle_allowance->status_id = '1';
        $bicycle_allowance->save();
        $bicycleride =new Bicycle_ride();
        $bicycleride->date =$request->rideDate;
        $bicycleride->user_id = auth()->user()->id;
        $bicycleride->save();



        return redirect('expense_allowances');
    }
}
