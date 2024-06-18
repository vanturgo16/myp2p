<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('auths.login');
    }

    public function postLogin(Request $request){
        //dd('hai');
        //dd($request->all());
        $email=$request->user_email;
        $password=$request->user_password;
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        $cekuser_status=User::where('email',$email)->first();

        if($cekuser_status->is_active=='1'){
            $dologin=Auth::attempt($credentials);
            if($dologin){
                session()->flash('status', 'Login Success');
                return redirect('/');
            }
            else{
                session()->flash('status', 'Wrong Email or Password');
                return redirect('/');
            }
        }
        else{
            session()->flash('status', 'Give Access First to User');
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        session()->flash('status', 'Logout Success!');
        return redirect('/');
    }
}
