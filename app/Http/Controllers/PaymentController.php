<?php

namespace App\Http\Controllers;

use App\Cost_center;
use App\Expense;
use App\Expense_allowance;
use App\Laptop_allowance;
use App\Proof;
use App\Status;
use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
     public function index(Request $request)
    {
        $result = ExpenseAllowanceReviewController::getDataForIndex($request,'%',2);
        Json::dump ($result);
        return view('payment.index', $result);
    }


    public function edit(Expense_allowance $expense_allowance )
    {
        $expenses =Expense::with('expense_allowance')
            ->where('expense_allowance_id','like',$expense_allowance->id)
            ->orderBy('date','DESC')
            ->paginate(10);
        $cost_center_manager="";
        if($expense_allowance->cost_center_manager_id) {
            $cost_center_manager = User::where('id', 'like', $expense_allowance->cost_center_manager_id)->first();
        }
        $financial_manager="";
        if($expense_allowance->financial_officer_id) {
            $financial_manager = User::where('id', 'like', $expense_allowance->financial_officer_id)->first();
        }
        $result = compact('expenses','financial_manager','cost_center_manager','expense_allowance');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        return view('payment.edit', $result);
    }
    public function edit2(Laptop_allowance $laptop_allowance )
    {
        $cost_center_manager="";
        if($laptop_allowance->cost_center_manager_id) {
            $cost_center_manager = User::where('id', 'like', $laptop_allowance->cost_center_manager_id)->first();
        }
        $financial_manager="";
        if($laptop_allowance->financial_officer_id) {
            $financial_manager = User::where('id', 'like', $laptop_allowance->financial_officer_id)->first();
        }
        $result = compact('laptop_allowance','financial_manager','cost_center_manager');           // compact('records') is the same as ['records' => $records]
        Json::dump ($result);

        return view('payment.edit2', $result);
    }
    public function update(Request $request,Expense_allowance $expense_allowance)
    {

        $expense_allowance->finance_approval_date = now();
        $expense_allowance->status_id = $request->approval_value;
        $expense_allowance->finance_comment= $request->comment;
        $expense_allowance->finance_approval_date= now();
        $expense_allowance->financial_officer_id = auth()->user()->id;
        $expense_allowance->save();
        if ($expense_allowance->status_id==3){
            $result=
            $result = compact('expense_allowance');

            Json::dump ($result);

            return view('payment.paid', $result);
        }else{
            return back();
        }
    }
    public function update2(Request $request,Laptop_allowance $laptop_allowance)
    {
        $laptop_allowance->finance_approval_date = now();
        $laptop_allowance->status_id = $request->approval_value;
        $laptop_allowance->finance_comment= $request->comment;

        $laptop_allowance->finance_approval_date= now();
        $laptop_allowance->financial_officer_id = auth()->user()->id;
        $laptop_allowance->save();
        if ($laptop_allowance->status_id==3){
            $result = compact('laptop_allowance');           // compact('records') is the same as ['records' => $records]
            Json::dump ($result);

            return view('payment.paidLaptop', $result);
        }else{
        return redirect('/payment_review');
        }
    }

    public function getProofs($expense_id){

        $proofs = Proof::orderby('proof','asc')->where('expense_id', 'like', $expense_id)->get();

        $response['data'] = $proofs;


        return response()->json($response);
    }
}
