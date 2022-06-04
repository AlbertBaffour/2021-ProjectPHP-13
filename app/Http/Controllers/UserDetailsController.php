<?php

namespace App\Http\Controllers;

use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::get();
        $result = compact('users');
        Json::dump('result');

        return view('modifyContactDetails', $result);
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
        //
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
    public function update(Request $request, User $user)
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

        auth()->user()->first_name = $request->first_name;
        auth()->user()->last_name = $request->last_name;
        auth()->user()->street_and_number = $request->street_and_number;
        auth()->user()->postcode = $request->postcode;
        auth()->user()->place = $request->place;
        auth()->user()->telephone = $request->telephone;
        auth()->user()->email = $request->email;
        auth()->user()->account_number = $request->account_number;
        auth()->user()->save();
        return redirect('modifyContactDetails');
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
