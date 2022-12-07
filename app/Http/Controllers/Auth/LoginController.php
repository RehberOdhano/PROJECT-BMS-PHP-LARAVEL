<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;


class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $req) {

        $validation_rules = array(
            'email' => 'required|email',
            'password' => 'required|alphanum|min:8',
        );

        $validator = Validator::make($req->all(), $validation_rules);

        if($validator->fails()) {
            return redirect('/login')->withErrors($validator)->withInput($req->except('password'));
        } else {
            if(Auth::attempt($req->only('email', 'password'))) {
                $role = User::where(['email' => $req->email, 'password' => $req->password])->first();
                return $role;           
            } 
        }

        
    }

}
