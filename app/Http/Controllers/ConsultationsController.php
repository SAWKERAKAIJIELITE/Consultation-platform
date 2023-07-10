<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Person;
use App\Models\wallet;
use App\Models\Consultations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationsController extends Controller
{
    use trait_response;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $user_id=$user->id;

        $user_wallet=wallet::where('owner_wallet_id',$user_id)->first();
        $user_wallet_value= $user_wallet->wallet_value;

        $cost=$request->validate(['cost'=>'bail|required|numeric']);
        $accept_cost=$cost['cost'];

        if($user_wallet_value<$accept_cost)
            return  $this->api_response(null,"you don't have enough money to afford this consultation please fill your wallet with $accept_cost at least ",400);

        $fields=$request->validate([
            'title'=> 'bail|required|string',
            'content'=> 'bail|required|string',
            'person_expert_id'=>'bail|required|integer'
        ]);

        $expert_id=$fields['person_expert_id'];

        if($expert_id===$user_id){
            return $this->api_response(null,'can\'t consulte yourself',400);
        }

        $speciality=Person::find($expert_id)->expereince()->getResults()->Specialises;

        $user_wallet->update(['wallet_value'=> $user_wallet_value - $accept_cost]);

        return Consultations::create([
            'title'=> $fields['title'],
            'content'=>$fields['content'],
            'Specialises'=>$speciality,
            'person_id'=> $user_id,
            'person_expert_id'=>$expert_id,
            'cost'=>$accept_cost
        ]);
    }

    /**
     * Display Expert's Consultations.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForExpert()
    {
        $user=Auth::user();
        $person=Person::find($user->id);

        return $person->Consultations_expert()->getResults();
    }

    /**
     * Display User's Consultations.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForUser()
    {
        $user=Auth::user();
        $person=Person::find($user->id);

        return $person->Consultations()->getResults();
    }

    /**
     * Transfere the cost of specified Consultation to the Expert.
     *
     *
     * @param  integer  $consultation_id
     * @return \Illuminate\Http\Response
     */
    public static function pay($consultation_id)
    {
        $consultation=Consultations::find($consultation_id);
        $is_finished=$consultation->isfinished;

        if($is_finished)
            return 'the cost of this consultation is paid';

        $expert_wallet=wallet::where('owner_wallet_id',$consultation->person_expert_id)->first();
        $expert_wallet_value=$expert_wallet->wallet_value;

        $reserve=$consultation->reserves()->getResults();
        $reserve_date=(int) $reserve[0]->date;

        $now=Carbon::now()->format('Ymd');

        if((int)$now>$reserve_date)
        {
            $consultation->update(['isfinished'=>1]);
            $cost=$consultation->cost;

            $expert_wallet->update(['wallet_value'=> $expert_wallet_value + $cost]);

            return [$expert_wallet->wallet_value];
        }
        else
            return 'this consultation hasn\'t finished yet';
    }

    /**
     * Rate a specified Cnsultation with specified value.
     *
     *
     * @param  integer  $id
     * @param  integer  $rate
     * @return \Illuminate\Http\Response
     */
    public function rate($id,$rate)
    {
        $consultation=Consultations::find($id);
        if ($consultation->rate!=null) {
            return 'this Consultation has rated before';
        }
        $consultation->update(['rate'=>$rate]);

        return 'Thank you for your feedback';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultations  $consultations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultations $consultations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultations  $consultations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultations $consultations)
    {
        //
    }
}
