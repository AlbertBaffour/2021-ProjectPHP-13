<?php

namespace App\Http\Controllers\Admin;

use App\Cost_setting;
use App\Http\Controllers\Controller;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $cost_settingsCar = Cost_setting::where('name',"perKmCar")->first();
    $cost_settingsBike = Cost_setting::where('name',"perKmBike")->first();
    $cost_settingsLaptop = Cost_setting::where('name', "Laptop")->first();
    $result = compact('cost_settingsCar', 'cost_settingsBike','cost_settingsLaptop');
    Json::dump('result');
    return view('costSettings', $result);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cost_Setting  $cost_setting
     * @return \Illuminate\Http\Response
     */
    public function show(Cost_Setting $cost_setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cost_Setting  $cost_setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Cost_Setting $cost_Setting)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cost_Setting  $cost_setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cost_Setting $cost_setting)
    {
        $this->validate($request,[
            'value' => 'required',

        ]);
        // Update user in the database and redirect to previous page




        $cost_setting->value = $request->value;
        $cost_setting->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cost_Setting  $cost_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cost_Setting $cost_setting)
    {
        //
    }
}
