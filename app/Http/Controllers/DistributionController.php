<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DistributionController extends Controller
{
    public function index()
    {
        if (session()->has('superadmin')) {
            $distributions = Distribution::where('id', '>=', 1)->get();
            return view('super-admin.distributions', [
                'distributions' => $distributions,
            ]);
        } else {
            return redirect('/');
        }
    }

    public function add_distribution(Request $req)
    {
        $dist_data = Distribution::where(['name' => $req->dist_name])->first();
        if ($dist_data == null) {
            $dist_data = new Distribution();
            $dist_data->name = $req->dist_name;
            $dist_data->contact = $req->dist_contact;
            $dist_data->address = $req->dist_address;
            $dist_data->save();
            session()->put('success', 'Distribution is successfully added.');
        } else {
            session()->put(
                'warning',
                'Distribution with this name already exists.'
            );
        }
        return redirect('/superadmin/distributions');
    }

    public function update(Request $req, $id)
    {
        $name = $req->dist_name;
        $contact = $req->dist_contact;
        $address = $req->dist_address;
        DB::update(
            'UPDATE distributions SET name = ?, contact = ?, address = ?
        WHERE id = ?',
            [$name, $contact, $address, $id]
        );
        session()->put('update', 'Distribution is successfully updated.');
        return redirect('/superadmin/distributions');
    }

    public function block_dist($id)
    {
        $dist_data = Distribution::where('id', '=', $id)->first();
        DB::update('UPDATE distributions SET status = ? WHERE id = ?', [
            'BLOCKED',
            $id,
        ]);

        User::where('email', $dist_data->admin)->update([
            'status' => 'BLOCKED',
        ]);

        User::where('distribution_id', $id)
            ->where('role', 3)
            ->update(['status' => 'BLOCKED']);

        session()->put('block', 'Distribution is successfully blocked');

        if (session()->has('admin')) {
            Session()->forget('admin');
        }
        if (session()->has('user')) {
            Session()->forget('user');
        }
        return redirect('/superadmin/distributions');
    }

    public function unBlockDist($id)
    {
        $dist_data = Distribution::where('id', '=', $id)->first();
        $lastPayment = DB::table('payments')->orderBy('id', 'DESC')->first();
        DB::update('UPDATE distributions SET status = ? WHERE id = ?', [
            $lastPayment->status,
            $id,
        ]);

        User::where('email', $dist_data->admin)->update([
            'status' => 'ACTIVE',
        ]);

        User::where('distribution_id', $id)
            ->where('role', 3)
            ->update(['status' => 'ACTIVE']);

        session()->put('unblock', 'Distribution is successfully unblocked');

        if (session()->has('admin')) {
            $adminData = User::where('email', $dist_data->admin)->first();
            session()->put('admin', $adminData);
        }
        if (session()->has('user')) {
            $userData = User::where('distribution_id', $id)
                ->where('role', 3)->first();
            session()->put('user', $userData);
        }
        return redirect('/superadmin/distributions');
    }

    public function add_dist_admin(Request $req, $id)
    {
        $data = User::where(['email' => $req->email])->first();

        // if the admin with email $req->email already exists then we just
        // display an error message otherwise we'll add the email of admin in
        // the admin's column of the distributions' table and also add a new
        // record/instance in the user's table
        if ($data != null) {
            session()->put(
                'error',
                'Admin with this email address is already registered.'
            );
            return redirect('/superadmin/distributions');
        } else {
            Distribution::where(['id' => $id])->update([
                'admin' => $req->email,
            ]);
            $admin = new User();
            $admin->distribution_id = $id;
            $admin->role = 2;
            $admin->name = $req->name;
            $admin->email = $req->email;
            $admin->status = 'ACTIVE';
            $admin->password = Hash::make($req->password);
            $admin->phone_number = $req->contact;
            $admin->city = $req->city;
            $admin->bio = "Hello... I'm Admin...";
            $admin->profile = "profile_bg.jpg";
            $admin->save();
            session()->put(
                'success',
                'Admin is successfully added to the distribution.'
            );
            return redirect('/superadmin/admins');
        }
    }

    // when a specific distribution is deleted, everything related to that like
    // payments, admins, etc will also be deleted...
    public function delete_dist($id)
    {
        $dist = Distribution::find($id);
        $dist->getDistSpecificPkgs()->delete();
        $dist->getSpecificDistAdmin()->delete();
        $dist->getSpecificDistPayment()->delete();
        $dist->getSpecificDistEmp()->delete();
        $dist->getDistSpecificCategories()->delete();
        $dist->getDistSpecificExpenses()->delete();
        $dist->getDistSpecificFlavors()->delete();
        $dist->getDistSpecificProducts()->delete();
        $dist->getDistSpecificStocks()->delete();
        $dist->getDistSpecificSuppliers()->delete();
        $dist->getDistSpecificLedger()->delete();
        $dist->getDistSpecificOutlet()->delete();
        $dist->getDistSpecificSale()->delete();
        $dist->getDistSpecificVehicle()->delete();
        $dist->getDistSpecificDebitCredit()->delete();
        $dist->delete();
        session()->put(
            'delete',
            'Distribution and related data is successfully deleted.'
        );
        return redirect('/superadmin/distributions');
    }

    public function search_distribution(Request $req)
    {
        $data = null;
        if ($req->input('query') == '') {
            $data = Distribution::where('id', '>=', 1)->get();
        } else {
            $data = Distribution::where('name', $req->input('query'))->get();
        }
        return view('super-admin.distributions', [
            'distributions' => $data,
            'query' => $req->input('query'),
        ]);
    }
}