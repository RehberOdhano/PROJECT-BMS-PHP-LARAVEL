<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Session();

class SuperAdminPanelController extends Controller
{
    public function profile()
    {
        if (session()->has('superadmin')) {
            $superadmin_id = session()->get('superadmin')['id'];
            $info = User::where('id', '=', $superadmin_id)->get();
            return view('super-admin.profile', ['profile_details' => $info]);
        } else {
            return redirect('/');
        }
    }

    public function editProfile(Request $req, $id)
    {
        $user_data = User::where('id', '=', $id)->first();
        $name = $req->name == '' ? $user_data->name : $req->name;
        $password =
            $req->password == '' ? $user_data->password : $req->password;
        $bio = $req->bio == '' ? $user_data->bio : $req->bio;
        $email = $req->email == '' ? $user_data->email : $req->email;
        $city = $req->city == '' ? $user_data->city : $req->city;
        $contact =
            $req->contact == '' ? $user_data->phone_number : $req->contact;

        $file_name = '';
        if ($req->profile != '' || $req->profile != null) {
            $file_name = $req->file('profile')->getClientOriginalName();
            $req->file('profile')->storeAs('public/images/', $file_name);
        }
        $profile = $req->profile == '' ? $user_data->profile : $file_name;

        DB::update(
            'UPDATE users SET name = ?, email = ?, password = ?, bio = ?, 
        phone_number = ?, city = ?, profile = ? WHERE id = ?',
            [$name, $email, $password, $bio, $contact, $city, $profile, $id]
        );

        session()->put('update', 'Profile is successfully updated.');
        return redirect('/superadmin/profile');
    }
}