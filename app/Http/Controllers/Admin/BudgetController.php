<?php

namespace App\Http\Controllers\Admin;

use App\Budget;
use App\Cost_center;
use App\Http\Controllers\Controller;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use function Symfony\Component\String\b;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
          public function index(Request $request)
    {
        $yearf = $request->input('yearf')??'';
        $budgets =Budget::orderBy('year')
            ->where('year', 'like' ,'%'.$yearf)
            ->get();

        $bgs =Budget::orderBy('year','desc')
            ->get();
        //available years
        foreach($bgs->unique('year') as $b){
            $years[]=($b->year);
        }
        //cost_centers
        $cost_centers = Cost_center::orderBy('name')
            ->get();
        $result = compact('budgets','years','cost_centers');

        Json::dump('result');
        return view('cost_center.budget', $result);
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
        $this->validate($request,[
            'amount' => 'required|regex:/^\d+(\,\d{1,2})?$/',
            'year'=>'required|digits:4|integer|min:'.(date('Y')-10).'|max:'.(date('Y')+20),
            'cost_center_id' => 'required'
        ]);
        $budget = new Budget();
        $budget->amount=$request->amount;
        $budget->year=$request->year;
        $budget->cost_center_id=$request->cost_center_id;
        $budget->created_at=now();
        $budget->save();
        return redirect('budgets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
               $this->validate($request,[
            'amount' => 'required|regex:/^\d+(\,\d{1,2})?$/',
            'year'=>'required|digits:4|integer|min:'.(date('Y')-10).'|max:'.(date('Y')+20),
            'cost_center_id2' => 'required'
        ]);
        $budget->amount=$request->amount;
        $budget->year=$request->year;
        $budget->cost_center_id=$request->cost_center_id2;
        $budget->updated_at=now();
        $budget->save();

        return redirect('budgets');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect('budgets');
    }
}
