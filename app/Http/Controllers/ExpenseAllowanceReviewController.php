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

class ExpenseAllowanceReviewController extends Controller
{

    public function index(Request $request)
    {
       $result = $this->getDataForIndex($request,auth()->user()->id,"%");
        Json::dump ($result);
        return view('expense_allowance_review.index', $result);
    }


  public function edit(Expense_allowance $expense_allowance )
{
    $expenses =Expense::with('expense_allowance')
        ->where('expense_allowance_id','like',$expense_allowance->id)
        ->orderBy('date','DESC')
        ->paginate(10);

    $result = compact('expenses','expense_allowance');           // compact('records') is the same as ['records' => $records]
    Json::dump ($result);

    return view('expense_allowance_review.edit', $result);
}
public function edit2(Laptop_allowance $laptop_allowance )
{

    $result = compact('laptop_allowance');           // compact('records') is the same as ['records' => $records]
    Json::dump ($result);

    return view('expense_allowance_review.edit2', $result);
}
    public function update(Request $request,Expense_allowance $expense_allowance)
    {

       $expense_allowance->approval_date = now();
       $expense_allowance->status_id = $request->approval_value;
       $expense_allowance->comment= $request->comment;
       $expense_allowance->cost_center_manager_id = auth()->user()->id;
        $expense_allowance->save();
        return redirect('/expense_allowance_review');
    }
    public function update2(Request $request,Laptop_allowance $laptop_allowance)
    {
       $laptop_allowance->approval_date = now();
       $laptop_allowance->status_id = $request->approval_value;
       $laptop_allowance->comment= $request->comment;
       $laptop_allowance->cost_center_manager_id = auth()->user()->id;
        $laptop_allowance->save();
        return redirect('/expense_allowance_review');
    }
    public function getProofs($expense_id){

        $proofs = Proof::orderby('proof','asc')->where('expense_id', 'like', $expense_id)->get();

        $response['data'] = $proofs;


        return response()->json($response);
    }
//fetch data for the index page/ used again at payment review
    public static function getDataForIndex(Request $request,$id,$status){
        $costCenters = Cost_center::where('user_id', 'like', $id)
            ->get();
        $status_id = ($status=="%"?($request->input('status_id')??'%'):$status);
        $status_id2 =($status=="%"?($request->input('status_id')??'%'):$status+1);
        $cost_center_id = $request->input('cost_center_id')??'%'; //OR $genre_id = $request->genre_id ?? '%';
        $naam = $request->input('name')??'';


        foreach($costCenters as $costcenter){
            $ccs[] = array($costcenter->id);
        }
        if($naam == ''){
            $users = User::orderby('first_name','asc')->select('id','first_name','last_name')->get();
        }else{
            $users = User::orderby('first_name','asc')->select('id','first_name','last_name')
                ->where('first_name', 'like', '%' .$naam . '%')
                ->orWhere('last_name', 'like', '%' .$naam . '%')->get();
        }

        $user_ids[]=array(0);
        foreach($users as $user){
            $user_ids[] = array($user->id);
        }

        $expense_allowances = Expense_allowance::
        whereIn('cost_center_id', $ccs)
            ->where('cost_center_id','like', $cost_center_id)
            ->where('status_id', 'like', $status_id)
            ->orWhere('status_id', 'like', $status_id2)
            ->whereIn('user_id', $user_ids)
            ->orderBy('submission_date','DESC')
            ->get();
        $laptop_allowances = Laptop_allowance::
        whereIn('cost_center_id', $ccs)
            ->where('cost_center_id','like', $cost_center_id)
            ->where('status_id', 'like', $status_id)
            ->orWhere('status_id', 'like', $status_id2)
            ->whereIn('user_id', $user_ids)
            ->orderBy('created_at','DESC')
            ->get();

        $statuses = Status::orderBy('name')
            ->has('expense_allowances')
            ->get();
        $cost_centers = Cost_center::orderBy('name')
            ->has('expense_allowances')
            ->get();

        $result = compact('expense_allowances','laptop_allowances','statuses','cost_centers');           // compact('records') is the same as ['records' => $records]
        return $result;
    }
}
