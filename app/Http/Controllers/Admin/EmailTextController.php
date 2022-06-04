<?php

namespace App\Http\Controllers\Admin;

use App\Email_text;
use App\Http\Controllers\Controller;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class EmailTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email_texts = Email_text::get();
        $result = compact('email_texts');
        Json::dump('result');
        return view('standardmail', $result);
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
     * @param  \App\Email_text  $email_text
     * @return \Illuminate\Http\Response
     */
    public function show(Email_text $email_text)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Email_text  $email_text
     * @return \Illuminate\Http\Response
     */
    public function edit(Email_text $email_text)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Email_text  $email_text
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email_text $email_text)
    {
        // Validate $request
        $this->validate($request,[
            'name' => 'required',
            'text' => 'required',
        ]);
        // Update user in the database and redirect to previous page

        $email_text->name = $request->name;
        $email_text->text = $request->text;

        $email_text->save();
        session()->flash('success', 'Your profile has been updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email_text  $email_text
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email_text $email_text)
    {
        //
    }
}
