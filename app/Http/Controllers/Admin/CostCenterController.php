<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Cost_center;
use App\User;
use Auth;
use App\Http\Controllers\Controller;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class CostCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_word = $request->input('search_word')??'';

        if($search_word == ''){
            $users = User::orderby('first_name','asc')->select('id','first_name','last_name')->get();
        }else{
            $users = User::orderby('first_name','asc')->select('id','first_name','last_name')
                ->where('first_name', 'like', '%'.$search_word.'%')
                ->orWhere('last_name', 'like', '%'.$search_word.'%')->get();
        }

        $user_ids[]=array(0);
        foreach($users as $user){
            $user_ids[] = array($user->id);
        }

        $cost_centers =Cost_center::orderBy('name')
//            ->withCount('expense_allowances')
            ->where('reference', 'like', '%' .$search_word . '%')
            ->orWhere('name', 'like', '%' .$search_word . '%')
            ->orwhereIn('user_id', $user_ids)
            ->get();
               $result = compact('cost_centers');

        Json::dump('result');
        return view('cost_center.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    redirect('cost_center.index');
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
            'name' => 'required|min:2',
            'reference'=>'required',
            'user_id' => 'required'
        ]);
        $cost_center = new Cost_center();
        $cost_center->name = $request->name;
        $cost_center->reference = $request->reference;
        $cost_center->user_id=$request->user_id;
        $cost_center->created_at=now();
        $cost_center->save();
        $user = User::where('id', 'like', $cost_center->user_id)
            ->first();
        $user->personnel_type_id=2;
        $user->save();
        return redirect('cost_centers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cost_center  $cost_center
     * @return \Illuminate\Http\Response
     */
    public function show(Cost_center $cost_center)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cost_center  $cost_center
     * @return \Illuminate\Http\Response
     */
    public function edit(Cost_center $cost_center)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cost_center  $cost_center
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cost_center $cost_center)
    {
        $this->validate($request,[
            'name' => 'required|min:2',
            'reference'=>'required',
            'user_id' => 'required'
        ]);
        $user = User::where('id', 'like', $cost_center->user_id)
            ->first();
        $cost_centers = Cost_center::where('user_id', 'like', $user->id)
            ->get();
        if($cost_centers->count()<2){
            $user->personnel_type_id=1;
            $user->save();
        }

        $cost_center->name = $request->name;
        $cost_center->reference = $request->reference;
        $cost_center->user_id=$request->user_id;
        $cost_center->created_at=now();
        $cost_center->save();
        $user = User::where('id', 'like', $cost_center->user_id)
            ->first();
        $user->personnel_type_id=2;
        $user->save();
        return redirect('cost_centers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cost_center  $cost_center
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cost_center $cost_center)
    {
        $user = User::where('id', 'like', $cost_center->user_id)
            ->first();
        $cost_centers = Cost_center::where('user_id', 'like', $user->id)
        ->get();
        if($cost_centers->count()<2){
            $user->personnel_type_id=1;
            $user->save();
        }
        App\Budget::where('cost_center_id', 'like', $cost_center->id)
            ->delete();
        $cost_center->delete();
        return redirect()->to('/cost_centers');
    }
    public function getUsers(Request $request){

        $search = $request->search;

        if($search == ''){
            $users = User::orderby('first_name','asc')->select('id','first_name','last_name')->limit(10)->get();
        }else{
            $users = User::orderby('first_name','asc')->select('id','first_name','last_name')
                ->where('first_name', 'like', '%' .$search . '%')
                ->orWhere('last_name', 'like', '%' .$search . '%')->limit(10)->get();
        }

        $response = array();
        foreach($users as $user){
            $response[] = array("value"=>$user->id,"label"=>$user->first_name.' '.$user->last_name);
        }

        return response()->json($response);
    }
}
