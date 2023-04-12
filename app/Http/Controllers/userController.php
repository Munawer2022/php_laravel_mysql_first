<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function register(Request $request){
         $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        if(User::where('email',$request->email)->first()){
            return response([
                'message'=>'Email already exists',
                'status'=>'failed'
            ],200);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken($request->email)->plainTextToken;
        return response([
            'user' => 'Registration success',
            'status' => 'success',
            'token' => $token
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'The provided credentials are incorrect.'
           ], 401);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response([
            'user' => 'login success',
            'status' => 'success',
            'token' => $token
        ], 200);

    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Succefully Logged Out !!',
            'status'=>'success'
        ],200);
    }
    public function logged_user(){
        $loggeduser=auth()->user();
        return response([
            'user'=>$loggeduser,
            'message' => 'Logged User Data',
            'status'=>'success'
        ],200);
    }
    public function change_password(Request $request){
        $request->validate([
           
            'password' => 'required|confirmed',
        ]);

        $loggeduser=auth()->user();
        $loggeduser->password=Hash::make($request->password);
        $loggeduser->save();
        return response([
           
            'message' => 'Password Change Successfully',
            'status'=>'success'
        ],200);
    }
}
