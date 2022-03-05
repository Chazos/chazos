<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthenticationController extends Controller
{
    //

    public function register(Request $request){

       try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('everyone');

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user
            ]);
       }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);

       }

    }


    public function csrf_token(Request $request){
        return response()->json([
            'status' => 'success',
            'message' => 'Token generated successfully',
            'token' => $request->session()->token()
        ]);
    }

      /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::where('id', Auth::id())->first();
            $token = $user->createToken('authToken');

            return response()->json([
                'status' => 'success',
                'message' => 'User authenticated',
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'token' => $token->plainTextToken
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials do not match our records'
        ]);
    }


    public function logout(Request $request)
{
    try{

        Auth::guard('web')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out'
        ]);
    }catch(\Exception $e){
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
}
