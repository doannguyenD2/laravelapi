<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;


class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        if($validate->fails()) return 'Loi';
        
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user'=> $user, 'accessToken' => $accessToken]);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validate->fails()) return 'Loi';

        if(!auth()->attempt($request->only('email','password')))
        {
            return 'Sai email hoac mat khau';
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user'=> auth()->user(), 'accessToken' => $accessToken]);

    }
}
