<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;
use Mail;
use App\Mail\Build;
use Illuminate\Support\Facades\Auth;



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
        $token = Str::random(40);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'email_verified' => $token,
        ]);
        $accessToken = $user->createToken('authToken')->accessToken;
        $url = env('APP_URL').'/verify'.'/'.$token;
        try
        {
            //fig bug
            Mail::to($request['email'])->send(new Build([
                'name' => $request['name'],
                'url'=> $url,
                'view' => 'mail.register',
            ],'Verify email'));

        }
        catch(Exception $e)
        {
            Log::info($e);
            return 'loi gui mail';
        }
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

    public function verify($token)
    {
        $user = User::where('email_verified',$token)->first();
        $message = 'Da xac nhan';
        if(empty($user))
        {
            $message = 'Loi verify/ da verify';
        }
        else {
            $user->email_verified = 1;
            $user->save();
        }
        return response(['message'=> $message]);
    }

    //send mail 
    // add role
    public function checkRole(Request $request)
    {
        // return response(['user'=>Auth::user()]);
        if(Auth::user()->authorizeRoles(['employee', 'admin']))
        return response('ok',200);
        else return response('not auth',501);
    }
}
