<?php

namespace App\Http\Controllers;

use App\Models\expereince;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpereinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiences=expereince::all();
        foreach ($experiences as $value) {
            echo $value."\n";

            echo $value->person()->getResults()->first_name."\n";
            echo $value->person()->getResults()->last_name."\n";
            echo $value->person()->getResults()->img_bath."\n";
            echo $value->person()->getResults()->country."\n";

        }
    }

    /**
     * Display a listing of the resource by spaeciality.
     *
     *
     * @param  string  $speciality
     * @return \Illuminate\Http\Response
     */
    public function indexBySpeciality($speciality)
    {
        $experiences=expereince::where('Specialises', $speciality)->get();
        foreach ($experiences as $value) {
            $person=$value->person()->getResults();
            echo response()->json([$person  , $value]);
        }
    }

    /**
     * Display a specified Expert.
     *
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person=Person::find($id);
        $personasexpert=$person->expereince()->getResults();

        return response()->json([$person,$personasexpert]);
    }

    /**
     * Display the Avaible times of specified Expert.
     *
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function showTimes($id)
    {
        $person=Person::find($id);
        $personasexpert=$person->expereince()->getResults();

        return $personasexpert->availble_times;
    }

    /**
     * create a new Expert.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $user_id=$user->id;

        $person= Person::find($user_id);

        if ($person->expert_id==null) {
            $fields=$request->validate([
                'Specialises'=> 'bail|required|string|alpha',
                'Experience'=> 'bail|required|string',
                'min'=> 'bail|required|numeric',
                'max'=> 'bail|required|numeric',
                'rate'=> 'bail|nullable|numeric',
            ]);

            $expert=expereince::create([
                'Specialises'=>$fields['Specialises'],
                'Experience'=>$fields['Experience'],
                'min'=>$fields['min'],
                'max'=>$fields['max'],
                'rate'=>$fields['rate'],
            ]);

            $person-> update(['expert_id'=> $expert->id]);

            return $person;
        }
        else
            return 'You are expert already';
    }

    /**
     * Search for a specified resource by its name.
     *
     * 
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $first=Person::whereNotNull('expert_id')
        -> where('first_name','like','%'.$name.'%')->get();

        $last=Person::whereNotNull('expert_id')
        -> where('last_name','like','%'.$name.'%')->get();

        return [$last,$first];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\expereince  $expereince
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, expereince $expereince)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\expereince  $expereince
     * @return \Illuminate\Http\Response
     */
    public function destroy(expereince $expereince)
    {
        //
    }
}
