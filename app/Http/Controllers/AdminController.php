<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Distribution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Session();

class AdminController extends Controller
{

    // will display all the admins on the superadmin dashboard
    public function listAdmins()
    {
        if (session()->has('superadmin')) {
            $admins = User::where('role', '=', 2)->get();
            $distIDs = array();

            foreach ($admins as $admin) {
                array_push($distIDs, $admin->distribution_id);
            }

            $distributions = DB::table('distributions')
                ->whereIn('id', $distIDs)->get();

            for ($i = 0; $i < count($admins); $i++) {
                $admins[$i]->dist = $distributions[$i];
            }
            return view('dist-admin-pages.admin-list', ["admins" => $admins]);
        } else return redirect('/');
    }

    // takes to the admin or user profile page based on the session data...
    public function profile()
    {
        if (session()->has('admin')) {
            $admin_id = session()->get('admin')['id'];
            $info = User::where('id', '=', $admin_id)->get();
            return view('dist-admin-pages.profile', ["details" => $info]);
        } else if (session()->has('user')) {
            $user_id = session()->get('user')['id'];
            $info = User::where('id', '=', $user_id)->get();
            return view('dist-admin-pages.profile', ["details" => $info]);
        } else return redirect('/');
    }

    // when the admin updates the profile info, the record in the users table
    // as well as in the distribution table will be updated...
    public function editAdminProfile(Request $req, $id)
    {
        $user_data = User::where('id', '=', $id)->first();
        $name = ($req->name == "") ? $user_data->name : $req->name;
        $password = ($req->password == "") ? $user_data->password : $req->password;
        $bio = ($req->bio == "") ? $user_data->bio : $req->bio;
        $email = ($req->email == "") ? $user_data->email : $req->email;
        $city = ($req->city == "") ? $user_data->city : $req->city;
        $contact = ($req->contact == "") ? $user_data->phone_number : $req->contact;

        // getting the original or complete file name and storing it
        $file_name = "";
        if ($req->profile != "" || $req->profile != null) {
            $file_name = $req->file('profile')->getClientOriginalName();
            $req->file('profile')->storeAs('public/images/', $file_name);
        }
        $profile = ($req->profile == "") ? $user_data->profile : $file_name;

        DB::update('UPDATE users SET name = ?, email = ?, password = ?, bio = ?, 
        phone_number = ?, city = ?, profile = ? WHERE id = ?', [
            $name, $email, $password, $bio, $contact, $city, $profile, $id
        ]);

        Distribution::where('id', '=', $user_data->distribution_id)
            ->update(['admin' => $email]);
        return redirect('/dists/admin/profile');
    }

    // when admins data is updated, the record in the users table 
    // as well as in the distribution table will be updated...
    public function edit(Request $req, $id)
    {
        $admin = User::where('id', $id)->first();
        $name = ($req->name == "") ? $admin->name : $req->name;
        $email = ($req->email == "") ? $admin->email : $req->email;
        $password = ($req->password == "") ? Hash::make($admin->password) : Hash::make($req->password);
        $contact = ($req->contact == "") ? $admin->phone_number : $req->contact;
        $address = ($req->address == "") ? $admin->city : $req->address;
        $bio = ($req->bio == "") ? $admin->bio : $req->bio;

        // updating the user's table
        DB::update('UPDATE users SET name = ?, email = ?, password = ?, phone_number = ?,
        bio = ?, city = ? WHERE id = ?', [
            $name, $email, $password, $contact, $bio,
            $address, $id
        ]);

        // updating the distributions' table
        Distribution::where('id', '=', $admin->distribution_id)
            ->update(['admin' => $email]);

        session()->put('update', 'Admin is successfully updated.');
        return redirect('/superadmin/admins');
    }

    // when admin is deleted, it's value will be deleted from the users table
    //  as well as from the distributions' table...
    public function delete($id)
    {
        $data = User::where(['id' => $id])->first();
        $dist_id = $data->distribution_id;

        // deleting all the data from the system that is added by the admin
        $admin = User::find($id);
        $admin->getAdminSpecificPkgs()->delete();
        $admin->getAdminSpecificEmp()->delete();
        $admin->getAdminSpecificCategories()->delete();
        $admin->getAdminSpecificExpenses()->delete();
        $admin->getAdminSpecificFlavors()->delete();
        $admin->getAdminSpecificProducts()->delete();
        $admin->getAdminSpecificStocks()->delete();
        $admin->getAdminSpecificSuppliers()->delete();
        $admin->getAdminSpecificLedger()->delete();
        $admin->getAdminSpecificOutlet()->delete();
        $admin->getAdminSpecificSale()->delete();
        $admin->getAdminSpecificVehicle()->delete();
        $admin->getAdminSpecificDebitCredit()->delete();
        // deleting the admin
        $admin->delete();

        // updating the distributions' table...
        Distribution::where('id', $dist_id)->update(['admin' => null]);

        session()->put('delete', 'Admin is successfully deleted.');
        return redirect('/superadmin/admins');
    }
}