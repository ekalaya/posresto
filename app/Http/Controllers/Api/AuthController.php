<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login api
    public function login(Request $request)
    {
        $request->validate([
            "email"=> "required|email",
            "password"=> "required"
            ]);
        
        $user = User::where("email", $request->email)->first();
        
        //login user
        if (!$user) {
            return response()->json([
                "status"=> "error",
                "message"=> "Invalid login details"
                ],401);
        }
        
        if(!Hash::check($request->password, $user->password)){
           return response()->json([
            "status"=> "error",
            "message"=> "Wrong Password"
            ],401);
        }

        $token = $user->createToken("auth-token")->plainTextToken;
        
        return response()->json([
            "status"=> "success",
            "token"=> $token,
            "user"=> $user
            ],200);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
                "status"=> "success",
                "message"=> "Log Out"
                ],200);
    }
    
}
