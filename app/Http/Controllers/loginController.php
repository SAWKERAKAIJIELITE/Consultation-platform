<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class loginController extends Controller
{
    use HasApiTokens;
    /**
     * Handle an authentication attempt.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $fields=$request->validate([
            'email'=> '|bail|string|email',
            'password'=> 'bail|required|string|min:8',
        ]);

        if (Auth::attempt($fields)) {
            return session()->all();

            return redirect()->intended('dashboard');
        }

        return 'd';
    }

    public function createTo(Request $request)
    {
        $token = $request->user()->createToken($request->token_name,['server:update']);

        return ['token' => $token->plainTextToken];
    }

    public function userTokens(Request $request)
    {
        return $request->user()->tokens;
    }

    public function getUserAbilities(Request $request)
    {
        return $request->bearerToken();
        // return Guard::getTokenFromRequest($request);
        // return $request->user()->tokenable();
        // return Sanctum::getAccessTokenFromRequestUsing(function()use ($request){$request->user()->currentAccessToken();});
        // return response()->json([PersonalAccessToken::findToken('2|gWYUd6reIjrQvcNkGBHLPwPam0jFfMWDUJbHiJx0')->tokenable()]);
    }
}
