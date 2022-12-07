<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;
use App\Models\User;

Session();

class OutletController extends Controller
{
    public function index()
    {
        if (session()->has('user')) {
            $id = session()->get('user')['id'];
            $dist_id = session()->get('user')['distribution_id'];
            $status = User::where('id', '=', $id)->select('status')->first();
        }
        if (session()->has('admin')) {
            $id = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
            $status = User::where('id', '=', $id)->select('status')->first();
        }

        if (strcmp($status->status, "BLOCKED") == 0) {
            if (session()->has('admin')) {
                session()->forget('admin');
            }
            if (session()->has('user')) {
                session()->forget('user');
            }
            return redirect('/');
        } else {
            $outlets = Outlet::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();
            return view('dist-admin-pages.outlets', ['outlets' => $outlets]);
        }
    }

    public function add_outlet(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $outletData = Outlet::where('user_id', $userID)
            ->where('distribution_id', $dist_id)
            ->where('name', $req->name)
            ->first();

        if ($outletData == null || strtolower($outletData->name) != strtolower($req->name)) {
            $outlet = new Outlet();
            $outlet->distribution_id = $dist_id;
            $outlet->user_id = $userID;
            $outlet->name = $req->name;
            $outlet->address = $req->address;
            $outlet->contact = $req->contact;
            $outlet->member_since = $req->date;
            $outlet->route = $req->route;
            $outlet->save();
            session()->put('success', 'Outlet is successfully added.');
        } else {
            session()->put('error', 'This outlet is adready added to the system!');
        }
        return redirect('/dists/admin/outlets');
    }

    public function edit_outlet(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }
        $name = $req->name;
        $address = $req->address;
        $contact = $req->contact;
        $member_since = $req->date;
        $route = $req->route;
        Outlet::where([['id', $id], ['user_id', $userID]])->update([
            'name' => $name,
            'address' => $address,
            'contact' => $contact,
            'route' => $route,
            'member_since' => $member_since,
        ]);
        session()->put('update', 'Outlet is successfully updated.');
        return redirect('/dists/admin/outlets');
    }

    public function getOutletRoutes(Request $req)
    {
        $routes = Outlet::where('name', '=', $req->name)->get();
        return response($routes);
    }

    public function delete_outlet($id)
    {
        Outlet::destroy($id);
        session()->put('delete', 'Outlet is successfully deleted.');
        return redirect('/dists/admin/outlets');
    }
}