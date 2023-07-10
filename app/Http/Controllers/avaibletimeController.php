<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Person;
use App\Models\reserve;
use App\Models\avaible_time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class avaibletimeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $person=Person::find($user->id);

        if($person->expereince()->getResults()==null)
            return 'you are not expert';

        $fields=$request->validate([
            'day'=> 'bail|required|date_format:Y-m-d',
            'time'=> 'bail|required|date_format:H:i',
            'period'=>'bail|required|date_format:H:i'
        ]);

        return avaible_time::create([
            'expert_id'=>$user->id,
            'day'=>$fields['day'],
            'time'=>$fields['time'],
            'period'=>$fields['period'],
        ]);
    }

    /**
     * Show avaible times for specified Expert during specified week.
     *
     * @param  integer  $id
     * @param  integer  $num
     * @return \Illuminate\Http\Response
     */
    public static function show($id,$num)
    {
        $avaible_times=avaible_time::where('expert_id', $id)->get();

        $reserves=reserve::where('person_expert_id',$id)->get('date');

        foreach ($avaible_times as $value) {
            $day=new Carbon($value->day);
            $next_days=$day->addDays(7*$num)->format('Y-m-d');

            $date=$next_days.' '.$value->time;

                foreach ($reserves as $reserve) {
                    if ($reserve->date==$date) {
                        echo "booked\n";
                        continue 2;
                    }
            }
            print($date.' '.$value->period."\n");
        }
    }
}
