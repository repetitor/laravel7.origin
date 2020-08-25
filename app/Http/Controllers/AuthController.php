<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     @OA\Response(response="200", description="try-post - An example resource"),
     *     @OA\Response(response="400", description="try-post - An example resource2")
     * )
     */
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        User::create(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'You were successfully registered. Use your email and password to sign in.'
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     @OA\Response(response="200", description="try-post - An example resource"),
     *     @OA\Response(response="400", description="try-post - An example resource2"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Login")
     *     ),
     * )
     */
    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($login)){
            return response(['message' => 'Invalid login credentials.']);
        }

        $accessToken = Auth::user()->createToken('Token la-la-la')->accessToken;

        return response([
            'user' => Auth::user(),
            'access_token' => $accessToken
        ]);
    }


    /**
     * @OA\Post(
     *     path="/logout",
     *     @OA\Response(response="200", description="try-post - An example resource"),
     *     @OA\Response(response="400", description="try-post - An example resource2"),
     *     @OA\Response(response="500", description="try-post - 22222ce2")
     * )
     */
    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You are successfully logged out',
        ]);
    }
}
