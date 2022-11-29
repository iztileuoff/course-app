<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request){

        $request->validated();

        $user = User::where('phone', $request->input('phone'))->first();

        $pass = Hash::check($request->input('password'), $user->password);
        if(!$pass){
            throw ValidationException::withMessages([
                'errors' => ['phone or password was invalid!']
            ]);
        }
        
        Auth::attempt(['phone' => $request->input('phone'), 'password' => $request->input('password')]);
        $token = $user->createToken($user->phone)->plainTextToken;
        return response([
            'message' => "successful login",
            'data' => [
                'token' => $token,
                'user_id' => $user->id
            ]
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => "successful logout"
        ];
    }

    public function check(Request $request)
    {
        return response([
            'message' => 'success',
            'data' => [
                'user_id' => $request->user()->id,
                'name' => $request->user()->name,
                'phone' => $request->user()->phone
            ]
        ]);
    }
}
