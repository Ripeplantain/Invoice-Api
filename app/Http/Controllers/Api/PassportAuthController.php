<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{
    public function register(Request $request){

        $validated_data = $request->validate([
                'name' => 'required|string|min:3|max:50',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|max:50'
            ]);
        
        $user = User::create($validated_data);
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token
        ], 201);
    }
    
    public function login(Request $request){
        $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6|max:50'
            ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $token = Auth::user()->createToken('auth_token')->accessToken;
            return response()->json([
                'message' => 'User logged in successfully',
                'token' => $token
            ], 200);
        }
        
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }
}
