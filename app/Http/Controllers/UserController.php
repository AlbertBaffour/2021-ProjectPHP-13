<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::get();
        $result = compact('users');
        Json::dump('result');

        return view('manageUsers', $result);
    }

    public function show()
    {
        return view('modifyContactDetails');
    }
}
