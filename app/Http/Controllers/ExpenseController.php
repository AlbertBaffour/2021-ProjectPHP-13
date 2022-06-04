<?php

namespace App\Http\Controllers;

use App\Cost_setting;
use App\Expense;
use App\Expense_allowance;
use App\Proof;
use DateTime;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('expense_allowance/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vPerKmCar = Cost_setting::where('name', 'like', "perKmCar")->first();
        $expense = new Expense();
        if ($request->cost){
            $expense->cost = $request->cost;
        }else{
            $expense->cost= $request->km*floatval($vPerKmCar->value);
        }
        if ($request->name){
            $expense->description = $request->name.' - '.$request->description;
        }else{
                $expense->description = $request->description. '(verplaatsing)';
        }
        if($request->km){
            $expense->total_km = $request->km;
        }else{ $expense->total_km =0; }
        $expense->date =$request->date;
        $expense->expense_allowance_id = $request->expense_allowance_id;
        $expense->save();

        //bewijs
        if($request->hasfile('filenames'))
        {
            foreach($request->file('filenames') as $file)
            {
                $name =now()->format('Y_m_d-H_i_s').'.'.$file->getClientOriginalName();
                $file->move(public_path().'/uploads/proofs', $name);
                $proof=new Proof();
                $proof->proof =$name;
                $proof->expense_id = $expense->id;
                $proof->save();
            }


        }

        $expense_allowance = Expense_allowance::where('id', 'like', $request->expense_allowance_id)->first();
        $expenses = Expense::where('expense_allowance_id', 'like', $expense_allowance->id)
            ->get();
        $result = compact('expense_allowance','expenses');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        // Go to the expense creation page
        return view('expense_allowance.expense.create', $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return redirect('expense_allowance/create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $expense_allowance = Expense_allowance::where('id', 'like', $expense->expense_allowance_id)->first();
        $proofs = Proof::where('expense_id', 'like', $expense->id)->get();
        $result = compact('proofs','expense','expense_allowance');
        Json::dump($result);
        return view('expense_allowance.expense.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $expense_allowance = Expense_allowance::where('id', 'like', $expense->expense_allowance_id)->first();
        $expense_allowance->submission_date =date("Y-m-d");
        $vPerKmCar = Cost_setting::where('name', 'like', "perKmCar")->first();
        if ($request->km){
            $expense->cost = $request->km* $vPerKmCar->value;
            $expense->total_km = $request->km;
        }else{ $expense->cost = $request->cost;
            $expense->total_km = 0;}
        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->save();
        //status updaten
        $expense_allowance->status_id=1;
        $expense_allowance->save();
        //bewijs
        if($request->hasfile('filenames'))
        {
            foreach($request->file('filenames') as $file)
            {
                $name =now()->format('Y_m_d-H_i_s').'.'.$file->getClientOriginalName();
                $file->move(public_path().'/uploads/proofs', $name);
                $proof=new Proof();
                $proof->proof =$name;
                $proof->expense_id = $expense->id;
                $proof->save();
            }
        }

           //session()->flash('success', 'The genre has been updated');
        return redirect('/expense_allowances/'.$expense->expense_allowance_id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect("/expense_allowances/".$expense->expense_allowance_id."/edit");
    }

}
