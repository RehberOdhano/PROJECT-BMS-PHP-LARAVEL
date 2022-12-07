<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
// use Cartalyst\Sentinel\Laravel\Facades\Reminder;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $user_data = User::where('email', $req->email)->first();
        // first it'll check wether the user exists... if so, then checks the email
        // and password...
        if (
            $user_data != null &&
            Hash::check($req->password, $user_data->password)
        ) {
            // if both are correct then based on the role it'll redirect to that
            // dashboard... if role is 1 then user will be redirected to the
            // superadmin dashboard
            if ($user_data->role == 1) {
                $req->session()->put('superadmin', $user_data);
                return redirect('/superadmin/dashboard');
            } else {
                // if role is 2 then it's an admin of a certain distribution...
                // so based on that distribution id, first we'll check status of
                // that distribution... if the status is BLOCKED then the admin
                // will be unable to access the system... otherwise the user will
                // successfully redirected to the admin dashboard...
                if ($user_data->status == 'BLOCKED') {
                    session()->put(
                        'warning',
                        'Your account is currently blocked!'
                    );
                    return redirect('/');
                } else {
                    if ($user_data->role == 2) {
                        $req->session()->put('admin', $user_data);
                        return redirect('/dists/admin/dashboard');
                    } else {
                        $req->session()->put('user', $user_data);
                        return redirect('/user/dashboard');
                    }
                }
            }
        } else {
            session()->put('message', 'Invalid email or password!');
            return redirect('/');
        }
    }

    // will logout the user from the system and destroy the session
    // data that was saved on the time of login...
    public function logout($roleID)
    {
        if ($roleID == 1) {
            Session()->forget('superadmin');
        } elseif ($roleID == 2) {
            Session()->forget('admin');
        } else {
            Session()->forget('user');
        }
        return redirect('/');
    }


    // will help the user to reset the password...
    // public function forgotPassword(Request $req) {
    //     $user = User::whereEmail($req->email)->first();
    //     // if the user does not exist, then he/she won't be able to reset the password
    //     // error displayed...
    //     if($user == NULL) {
    //         session()->put("error", "Email not found!");
    //         return redirect()->back();
    //     } else {
    //         // if the user exists, then a reset password link will be sent to
    //         // user's email address and the user after entering the details,
    //         // can successfully reset the password...
    //         $user = Sentinel::findById($user->id);
    //         $reminder = Reminder::create($user);
    //         $this->sendEmail($user, $reminder->code);
    //         session()->put('email', $req->email);
    //         session()->put("success", "Reset Password link has been sent successfully.");
    //         return redirect()->back();
    //     }
    // }

    // this will send an email from the system to that user's 
    // email address...
    // public function sendEmail($user, $code) {
    //     Mail::send(
    //         'email.forgot',
    //         ['user' => $user, 'code' => $code],
    //         function($message) use ($user) {
    //             $message->to($user->email);
    //             $message->subject("$user->name, reset your password.");
    //         }
    //     );
    // }

    // this will update the user's password
    // public function resetPassword(Request $req)
    // {
    //     $sentEmail = session()->get('email');
    //     $user = User::where('email', $req->email)->first();
    //     $password = Hash::make($req->password);
    //     // if the user does not exist, error will be displayed... Otherwise,
    //     // the user's password will be updated in the user's table successfully...
    //     if ($user != null && $req->email == $sentEmail) {
    //         DB::update('UPDATE users SET password = ? WHERE email = ?', [
    //             $password,
    //             $req->email,
    //         ]);
    //         session()->put('reset', 'Password is successfully reset!');
    //         return redirect('/');
    //     } else {
    //         session()->put('error', 'Email not found!');
    //         return redirect()->back();
    //     }
    // }
}