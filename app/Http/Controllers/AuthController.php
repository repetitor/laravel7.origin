<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Notifications\InvoicePaid;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::create(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->password)]
        ));

//        $user->sendEmailVerificationNotification();

        event(new Registered($user));

//        $user->notify(new InvoicePaid($invoice));

        return response()->json([
            'message' => 'You were successfully registered. Use your email and password to sign in.'
        ], 200);
    }

    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($login)){
            return response(['message' => 'Invalid login credentials.']);
        }

//        $this->middleware('verified');

        $accessToken = Auth::user()->createToken('Token la-la-la')->accessToken;

//        Auth::user()->middleware('verified');
//        $this->middleware('auth');
//        Auth::user()->middleware('auth');

//        Auth::user()->notify((new InvoicePaid('$invoice'))->locale('es'));

        return response([
            'user' => Auth::user(),
            'access_token' => $accessToken
        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You are successfully logged out',
        ]);
    }
}
