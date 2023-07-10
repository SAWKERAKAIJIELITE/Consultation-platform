<?php

namespace App\Http\Controllers;

use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();

        $fields=$request->validate([
            'wallet_value'=> 'bail|required|numeric|between:0,1000000',
            'wallet_num'=> 'bail|required|numeric|min:4',
            'password'=> 'bail|required|string|confirmed|min:8',
        ]);

        return wallet::create([
        'wallet_value'=> $fields['wallet_value'],
        'wallet_num'=>$fields['wallet_num'],
        'password'=>$fields['password'],
        'owner_wallet_id'=> $user->id
        ]);
    }

    public function addvalue(Request $request)
    {
        $user=Auth::user();

        $accept_value=$request->validate(['wallet_value'=>'bail|required|numeric|min:1']);

        $user_wallet=wallet::where('owner_wallet_id',$user->id)->first();

        $user_wallet_value= $user_wallet->wallet_value;

        $user_wallet->update(['wallet_value'=> $user_wallet_value+$accept_value['wallet_value']]);

        return 'Updated Succefully';
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user=Auth::user();
        return wallet::where('owner_wallet_id',$user->id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(wallet $wallet)
    {
        //
    }
}
