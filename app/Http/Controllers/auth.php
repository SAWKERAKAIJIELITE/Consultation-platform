<?php

namespace App\Http\Controllers;

use App\Models\expereince;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class auth extends Controller
{
    use HasApiTokens;

    public function register(Request $request){

    $fields=$request->validate([
        'first_name'=> 'bail|required|string|alpha',
        'last_name'=> 'bail|required|string|alpha',
        'img_bath'=> 'bail|nullable|image|mimes:jpg,bmp,png,svg,jpeg',
        'country'=> 'bail|required|string',
        'city'=> 'bail|required|string',
        'gender'=> 'bail|required|string',
        'birth_date'=> 'date',
        'email'=> 'bail|required|email',
        'password'=> 'bail|required|string|min:8',
    ]);

    $image=$request->file('img_bath');
    $saveimage=time().'.'.$image->getClientOriginalExtension();
    $image->move(public_path('image'),$saveimage);

    $people=Person::create([
        'first_name'=>$fields['first_name'],
        'email'=>$fields['email'],
        'password'=>bcrypt($fields['password'])  ,
        'last_name'=>$fields['last_name'],
        'img_bath'=>'image/'.$saveimage,
        'country'=>$fields['country'],
        'city'=>$fields['city'],
        'gender'=>$fields['gender'],
        'birth_date'=>$fields['birth_date']
    ]);

    $token=$people->createToken('Sing-up-token')->plainTextToken;

    $response=[
        'user'=>$people,
        'token'=>$token,
    ];

    return response($response,201);
    }

    public function login(Request $request){

    $fields=$request->validate([
        'email'=> '|bail|string|email',
        'password'=> 'bail|required|string|min:8',
    ]);

    $people=Person::where('email',$fields['email'])->first();

    if(!$people || !Hash::check($fields['password'],$people->password)){
        return response(['message'=>"bad"],401);
    }

    $token=$people->createToken('log-in-token',['server:update'])->plainTextToken;

    $response=[
        'user'=>$people,
        'token'=>$token,
    ];

    return response($response,201);
    }

    public function logout(Request $request)
    {
    $user_id=$request->user()->id;

    PersonalAccessToken::where('tokenable_id',$user_id)->where('name','login token')->delete();

    return ['message'=>'logged out'];
    }

    public function delete_account(Request $request)
    {
    $user=FacadesAuth::user();

    $person=Person::find($user->id);

    $expert_id=$person->expert_id;

    $person->delete();
    expereince::where('id',3)->delete();

    $request->user()->tokens()->delete();

    return ['message'=>'account destroyed :('];
    }
}
