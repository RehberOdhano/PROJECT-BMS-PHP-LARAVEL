<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Session();

class UsersController extends Controller
{
  // display all the users
  public function index()
  {
    if(session()->has('user')) {
      $user = session()->get('user');
      $status = User::where('id', '=', $user->id)->select('status')->first();
    } if(session()->has('admin')) {
      $admin = session()->get('admin');
      $status = User::where('id', '=', $admin->id)->select('status')->first();
    }
    
    if(strcmp($status->status, "BLOCKED") == 0) {
      if(session()->has('admin')) {
        session()->forget('admin');
      }
      if(session()->has('user')) {
        session()->forget('user');
      }
      return redirect('/');
    } else {
      $users = User::where('role', '=', 3)->get();
      return view('dist-admin-pages.users', ['users' => $users]);
    }
  }

  // this will add a new user... first it'll check whether the user with email
  // $req->email already exists or not... if exists, then it'll send back a warning
  // message otherwise a new user will be added to the database...
  public function addUser(Request $req)
  {
    $user = User::where('email', '=', $req->email)->first();
    $dist_id = session()->get('admin')['distribution_id'];
    $admin_id = session()->get('admin')['id'];
    if ($user == null) {
      $user = new User();
      $user->role = 3;
      $user->admin_id = $admin_id;
      $user->status = 'ACTIVE';
      $user->distribution_id = $dist_id;
      $user->password = Hash::make($req->password);
      $user->name = $req->name;
      $user->email = $req->email;
      $user->phone_number = $req->contact;
      $user->bio = "I'm a user...";
      $user->profile = "profile_bg.jpg";
      $user->city = $req->city;
      $user->save();
      session()->put('success', 'User is successfully added.');
    } else {
      session()->put(
        'warning',
        `User with email '$req->email' already exists!`
      );
    }
    return redirect('/dists/admin/users');
  }

  public function editUser(Request $req, $id)
  {
    $user_data = User::where('id', '=', $id)->first();
    $name = $req->name == '' ? $user_data->name : $req->name;
    $email = $req->email == '' ? $user_data->email : $req->email;
    $contact = $req->contact == '' ? $user_data->phone_number : $req->contact;
    $address = $req->address == '' ? $user_data->city : $req->address;

    DB::update('UPDATE users SET name = ?, email = ?, phone_number = ?, city = ? WHERE id = ?',
    [$name, $email, $contact, $address, $id]);
    session()->put('update', 'User is successfully updated.');
    return redirect('/dists/admin/users');
  }

  public function deleteUser($id)
  {
    User::destroy($id);
    session()->put('delete', 'User is successfully deleted.');
    return redirect('/dists/admin/users');
  }
}