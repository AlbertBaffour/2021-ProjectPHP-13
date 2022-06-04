<?php

namespace App\Http\Controllers;

use App\Laptop;
use App\Laptop_allowance;
use App\Status;
use App\Cost_center;
use DateTime;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class LaptopAllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return redirect('expense_allowances');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('laptop_allowance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate $request
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'price'=>'required|regex:/^\d+(\,\d{1,2})?$/',
            'brand' => 'required',
            'purchaseDate'=>'required|Date',
            'cost_center_id'=>'required'
        ]);

        $laptop =new Laptop();
        $laptop->name = $request->name;
        $laptop->description=$request->description;
        $laptop->price=$request->price;
        $laptop->brand=$request->brand;
        $laptop->user_id=auth()->id();
//        $laptop->purchase_date =DateTime::createFromFormat('m/d/Y', $request->purchaseDate)->format('Y-m-d');
        $laptop->purchase_date =$request->purchaseDate;
        if($request->hasfile('invoice')) {
            $name = now()->format('Y_m_d-H_i_s') . '.' . $request->invoice->getClientOriginalName();
            $request->invoice->move(public_path() . '/uploads/proofs', $name);
            $laptop->invoice = $name;
        }
        $laptop->save();

        $laptop_allowance = new Laptop_allowance();
        $laptop_allowance->cost_center_id = $request->cost_center_id;
        $laptop_allowance->laptop_id = $laptop->id;
        $laptop_allowance->user_id = auth()->user()->id;
        $laptop_allowance->status_id = '1';
        $laptop_allowance->save();

        return redirect('expense_allowances');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laptop_allowance  $laptop_allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Laptop_allowance $laptop_allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laptop_allowance  $laptop_allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Laptop_allowance $laptop_allowance)
    {
        $result = compact('laptop_allowance');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        return view('laptop_allowance.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laptop_allowance  $laptop_allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laptop_allowance $laptop_allowance)
    {
        // Validate $request
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'price'=>'required|regex:/^\d+(\,\d{1,2})?$/',
            'brand' => 'required',
            'purchaseDate'=>'required|Date',
            'cost_center_id'=>'required'
        ]);
        $laptop=Laptop::where('id', 'like', $request->laptop_id)
            ->first();
        $laptop->name=$request->name;
        $laptop->description=$request->description;
        $laptop->price=$request->price;
        $laptop->brand=$request->brand;
        $laptop->user_id=auth()->id();
        $laptop->purchase_date =$request->purchaseDate;
        if($request->hasfile('invoice')) {
            $name = now()->format('Y_m_d-H_i_s') . '.' . $request->invoice->getClientOriginalName();
            $request->invoice->move(public_path() . '/uploads/proofs', $name);
            $laptop->invoice = $name;
        }
        $laptop->save();

        $laptop_allowance->cost_center_id = $request->cost_center_id;
        $laptop_allowance->laptop_id = $laptop->id;
        $laptop_allowance->user_id = auth()->user()->id;
        $laptop_allowance->status_id = '1';
        $laptop_allowance->save();

        return redirect('expense_allowances');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laptop_allowance  $laptop_allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laptop_allowance $laptop_allowance)
    {
        $laptop= Laptop::where('id', 'like', $laptop_allowance->laptop_id)->first();
        $laptop_allowance->delete();
        $laptop->delete();
        return redirect("/expense_allowances");

    }
    public function getLaptops(){

        $laptops = Laptop::orderby('brand','asc')->where('user_id', 'like', auth()->user()->id)->get();

        $response['data'] = $laptops;


        return response()->json($response);
    }
}
