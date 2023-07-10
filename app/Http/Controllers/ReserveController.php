<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\avaible_time;
use App\Models\reserve;
use Illuminate\Http\Request;
use App\Models\Consultations;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choice($choice_day,$choice_hour,$id)
    {
        $day=new Carbon($choice_day);

        return avaible_time::where([['expert_id',$id],['day',$choice_day],['time',$choice_hour]])->update(['day'=>$day->addDays(7)]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForExpert()
    {
        $id=Auth::user()->id;

        return  reserve::where('person_expert_id',$id)->get();
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
        $consultation=Consultations::find($request->consultation_id);

        $expert_id=$consultation->person_expert_id;

        $choice_day=$request->choice_day;
        $choice_hour=$request->choice_hour;

        ReserveController::choice($choice_day,$choice_hour,$expert_id);

        $fields=$request->validate([
            'place'=> 'bail|required|string',
            'content'=>'bail|required|string'
        ]);

        $reserve=reserve::create([
            'date'=>$choice_day.' '.$choice_hour,
            'place'=>$fields['place'],
            'period'=>$request->period,
            'content'=>$fields['content'],
            'person_id'=> $consultation->person_id,
            'person_expert_id'=>$expert_id,
            'consultation_id'=>$consultation->id
        ]);

        ConsultationsController::pay($request->consultation_id);

        return $reserve;
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reserve $reserve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function destroy(reserve $reserve)
    {
        //
    }
}
