<?php

namespace App\Http\Controllers\Admin;

use App\Personnel_type;
use App\Unit;
use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ManageUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::get();
        $units = Unit::get();
        $personnel_types = Personnel_type::get();
        $result = compact('users', 'units', 'personnel_types');
//        $result = compact('users');
        Json::dump($result);

        return view('manageUsers', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    function save(Request $request){

        $user = new User;
        $user->password =  Hash::make($request->password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->street_and_number = $request->street_and_number;
        $user->postcode = $request->postcode;
        $user->place = $request->place;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        $user->account_number = $request->account_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->unit_id = $request->unit_id;
        $user->personnel_type_id = $request->personnel_type_id;
        $user->start_date = $request->start_date;
        $user->total_km = $request->total_km;
        $user->save();
        session()->flash('success', "De gebruiker <b>$user->first_name $user->last_name</b>is toegevoegd!");
        return redirect('manageUsers');
    }

    public function create()
    {
        $user = new User();
        $personnel_types = Personnel_type::get();
        $units = Unit::get();
        $result = compact('user', 'personnel_types', 'units');
        return view('createUser', $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required','Y-m-d:i:s',
            'personnel_type_id' => 'required',
            'unit_id' => 'required',
            'email' => 'required',
            'place' => 'required',
            'street_and_number' => 'required',
            'start_date' => 'required',
            'password' => 'required',
            'total_km' => 'required'
        ]);

        $user = new User();
        $user->password = $request->password;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->street_and_number = $request->street_and_number;
        $user->postcode = $request->postcode;
        $user->place = $request->place;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        $user->account_number = $request->account_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->unit_id = $request->unit_id;
        //$user->personnel_type_id = $request->personnel_type_id;
        $user->start_date = $request->start_date;
        $user->total_km = $request->total_km;
        $user->save();
        session()->flash('success', "De gebruiker <b>$user->first_name $user->last_name</b>is toegevoegd!");
        return redirect('manageUsers');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user, Unit $unit)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            //'date_of_birth' => 'required',
            'email' => 'required',
            'street_and_number' => 'required',
            'postcode' => 'required',
            'place' => 'required',
            //'personnel_type_id' => 'required',
            //'unit_id' => 'required'

        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->street_and_number = $request->street_and_number;
        $user->postcode = $request->postcode;
        $user->place = $request->place;
        $user->telephone = $request->telephone;
        $user->email = $request->email;
        $user->account_number = $request->account_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->unit_id = $request->unit_id;
        $user->personnel_type_id = $request->personnel_type;
        $user->start_date = $request->start_date;
        $user->total_km = $request->total_km;
//        $user->active = $request->active;
        $user->save();
        return redirect('manageUsers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
