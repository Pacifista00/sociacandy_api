<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return response()->json(Auth::user());
    }
    public function register(Request $request){
        $request->validate([
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'password_confirm' => ['required', 'same:password'],
        ]);
        
        if(User::where('email', $request->email)->exists()){
            return response()->json([
                'message' => 'Email already exist!'
            ]);
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2
        ]);
        return response()->json([
            'message' => 'Register success!'
        ]);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json('Login failed!');
        }
     
        return response()->json([
            'message' => 'Login success!',
            'token' => $user->createToken('token_id')->plainTextToken
        ]);        
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success!'
        ]);
    }
}
