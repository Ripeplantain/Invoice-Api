<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

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
        $validated_data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6|max:50'
            ]);

        $user = User::where('email', $validated_data['email'])->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        if(Hash::check($validated_data['password'], $user->password)){
            return response()->json([
                'message' => 'User logged in successfully',
                'token' => $user->createToken('auth_token')->accessToken
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid Password',
        ], 401);
    }

    public function logout(){
        $user = Auth::user();

        $user->tokens->each(function($token, $key){
            $token->delete();
        });

        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }

    public function refresh(Request $request){
        $user = $request->user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(['token' => $token], 200);
    }
}
