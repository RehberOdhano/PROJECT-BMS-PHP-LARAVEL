<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;

Session();
class SupplierController extends Controller
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
            $suppliers = Supplier::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();
            return view('dist-admin-pages.suppliers', ['suppliers' => $suppliers]);
        }
    }

    public function add_supplier(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $supplier = new Supplier();
        $supplier->user_id = $userID;
        $supplier->distribution_id = $dist_id;
        $supplier->name = $req->name;
        $supplier->contact = $req->contact;
        $supplier->address = $req->address;
        $supplier->supplier_since = $req->date;
        $supplier->save();
        session()->put('success', 'Supplier is successfully added.');
        return redirect('/dists/admin/suppliers');
    }

    public function edit_supplier(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }

        $supplier = Supplier::where("id", '=', $id)
            ->where('user_id', $userID)->first();

        $name = ($req->name == "") ? $supplier->name : $req->name;
        $contact = ($req->contact == "") ? $supplier->contact : $req->contact;
        $address = ($req->address == "") ? $supplier->address : $req->address;
        $date = ($req->date == "") ? $supplier->date : $req->date;
        Supplier::where([
            ["id", $id],
            ["user_id", $userID]
        ])->update([
            "name" => $name,
            "contact" => $contact,
            "address" => $address,
            "supplier_since" => $date
        ]);
        session()->put('update', 'Supplier is successfully updated.');
        return redirect('/dists/admin/suppliers');
    }

    public function delete_supplier($id)
    {
        Supplier::destroy($id);
        session()->put('delete', 'Supplier is successfully deleted.');
        return redirect('/dists/admin/suppliers');
    }
}