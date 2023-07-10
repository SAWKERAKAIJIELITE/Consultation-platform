<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Person::all();
    }

    /**
     * Display the rate of the Expert.
     *
     * @return \Illuminate\Http\Response
     */
    public function rated()
    {
        $user=Auth::user();
        $person=Person::find($user->id);

        $my_consultations=$person->Consultations_expert()->whereNotNull('rate')->getResults();
        $sum_rate=$num=0;

        foreach($my_consultations as $value)
        {
            $sum_rate+=$value->rate;
            $num++;
        }

        return $final=$sum_rate/$num;
    }

    /**
     * Display Reserves of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function showReservesForUser()
    {
        $id=Auth::user()->id;

        return reserve::where('person_id',$id)->get();
    }

    /**
     * Add Experts to the User's Favourite list.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addFavourites(Request $request)
    {
        $user=Auth::user();

        $person=Person::find($user->id);

        $json_content=json_decode($person->favourites);

        $json_content[]=(int)$request->expert_id;
        $favourites=json_encode($json_content);

        return $person->update([
            'favourites'=>$favourites
        ]);
    }

    /**
     * Display the Favourite list of the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFavourites()
    {
        $id=Auth::user()->id;

        $person=Person::find($id);
        $json_content=json_decode($person->favourites);

        foreach($json_content as $value)
            print (Person::find($value));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
