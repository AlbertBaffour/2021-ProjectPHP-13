<?php

namespace App\Http\Controllers;

use App\Cost_center;
use App\Expense;
use App\Expense_allowance;
use App\Laptop_allowance;
use App\Status;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class ExpenseAllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
            public function index(Request $request)
    {

        $status_id = $request->input('status_id')??'%';
         $cost_center_id = $request->input('cost_center_id')??'%';
         $type_v = $request->input('type_v')??'%';
        //get expense allowances
         $expense_allowances = Expense_allowance::with('status')
            ->where('status_id', 'like', $status_id)
            ->where('cost_center_id', 'like', $cost_center_id)
            ->where('user_id','like',auth()->user()->id)
             ->orderBy('submission_date','DESC')
            ->get();
         //get laptop allowances
        $laptop_allowances = Laptop_allowance::with('status')
            ->where('status_id', 'like', $status_id)
            ->where('cost_center_id', 'like', $cost_center_id)
            ->where('user_id','like',auth()->user()->id)
            ->orderBy('created_at','DESC')
            ->get();
        //get statuses en cost centers
        $statuses = Status::orderBy('name')
            ->has('expense_allowances')
            ->orHAs('laptop_allowances')
            ->get();
        $cost_centers = Cost_center::orderBy('name')
            ->has('expense_allowances')
            ->get();
        $result = compact('expense_allowances','laptop_allowances','statuses','cost_centers');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        return view('expense_allowance.index', $result);
    }
    public function getSorted(Request $request, $value)
    {
        $status_id = $request->input('status_id')??'%'; //OR $genre_id = $request->genre_id ?? '%';
        $type_v = $request->input('type_v')??'%'; //OR $genre_id = $request->genre_id ?? '%';

        //filter on clicked column
        if($value=="status_id"){

            $expense_allowances = Expense_allowance::with('status')
                ->where('status_id', 'like', $status_id)
                ->where('user_id','like',auth()->user()->id)
                ->orderBy($value,'ASC')
                ->get();
            $laptop_allowances = Laptop_allowance::with('status')
                ->where('status_id', 'like', $status_id)
                ->where('user_id','like',auth()->user()->id)
                ->orderBy($value,'ASC')
                ->get();
        }else{
        $expense_allowances = Expense_allowance::with('status')
            ->where('status_id', 'like', $status_id)
            ->where('user_id','like',auth()->user()->id)
            ->orderBy($value,'DESC')
            ->get();
        $laptop_allowances = Laptop_allowance::with('status')
            ->where('status_id', 'like', $status_id)
            ->where('user_id','like',auth()->user()->id)
            ->orderBy($value,'DESC')
            ->get();
        }

        //get statuses
        $statuses = Status::orderBy('name')
            ->has('expense_allowances')
            ->withCount('expense_allowances')
            ->get();
        //get cost centers
        $cost_centers = Cost_center::orderBy('name')
            ->has('expense_allowances')
            ->get();

        $result = compact('expense_allowances','laptop_allowances','statuses','cost_centers');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);
        return view('expense_allowance.index', $result);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function create()
{
    $cost_centers= Cost_center::all()
        ->transform(function ($item) {
            unset($item['description'], $item['timestamps']);
            return $item;
        });
    // To avoid errors with the 'old values' inside the form, we have to send an empty Record object to the view
    $expense_allowance = new Expense_allowance();
    $result = compact('cost_centers','expense_allowance');           // compact('records') is the same as ['records' => $records]
    Json::dump ($result);

    return view('expense_allowance.create',$result);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'title' => 'required',
//            'cost_center_id' => 'required',
//        ]);
        $expense_allowance = new Expense_allowance();
        $expense_allowance->name = $request->title;
        $expense_allowance->submission_date =date("Y-m-d");
        $expense_allowance->user_id = auth()->user()->id;
        $expense_allowance->status_id = '1';
        $expense_allowance->cost_center_id= $request->cost_center_id;
        $expense_allowance->created_at =date("Y-m-d");
        $expense_allowance->save();

        $expenses = Expense::where('expense_allowance_id', 'like', $expense_allowance->id)
            ->paginate(10);
        $result = compact('expense_allowance','expenses');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        // Go to the expense creation page
        return view('expense_allowance.expense.create', $result);
        //return redirect("/expenses/$expense_allowance->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense_allowance  $expense_allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Expense_allowance $expense_allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense_allowance  $expense_allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense_allowance $expense_allowance)
    {

        $expenses =Expense::with('expense_allowance')
            ->where('expense_allowance_id','like',$expense_allowance->id)
            ->orderBy('date','DESC')
            ->paginate(10);

        $result = compact('expenses','expense_allowance');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        return view('expense_allowance.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense_allowance  $expense_allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense_allowance $expense_allowance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense_allowance  $expense_allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense_allowance $expense_allowance)
    {
        $expense_allowance->delete();
        return redirect("/expense_allowances");
    }

    public function getMenu()
    {
        return view('expense_allowance.menu');
    }
    public function getCostCenters(Request $request){

        $search = $request->search;

        if($search == ''){
            $cost_centers = Cost_center::orderby('name','asc')->select('id','name')->limit(5)->get();
        }else{
            $cost_centers = Cost_center::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($cost_centers as $cost_center){
            $response[] = array("value"=>$cost_center->id,"label"=>$cost_center->name);
        }

        return response()->json($response);
    }

}
