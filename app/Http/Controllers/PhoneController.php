<?php

namespace App\Http\Controllers;

use App\Models\phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();

        $fields=$request->validate([
            'country_code'=> 'bail|required|integer',
            'phone'=> 'bail|required|string|min:8'
        ]);

        return phone::create([
        'country_code'=> $fields['country_code'],
        'phone'=>$fields['phone'],
        'owner_phone_id'=> $user->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user=Auth::user();

        $phones=phone::where('owner_phone_id',$user->id)->get();
        foreach($phones as $value)
            echo $value->people()->getResults();
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, phone $phone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param  \App\Models\phone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(phone $phone)
    {
        //
    }
}
