<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use App\Models\Product;

Session();

class PackageController extends Controller
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
            $data = Package::where([
                ['user_id', $id],
                ['distribution_id', $dist_id]
            ])->get();
            return view('dist-admin-pages.packages', ["packages" => $data]);
        }
    }

    public function add_package(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $packageData = Package::where('user_id', $userID)
            ->where('distribution_id', $dist_id)
            ->where('pkg_type', $req->pkg_type)
            ->where('size', $req->package_size . $req->units)
            ->where('pkg_name', $req->pkgName)
            ->first();

        if ($packageData == null) {
            $package = new Package();
            $package->pkg_type = $req->pkg_type;
            $package->size = $req->package_size . $req->units;
            $package->pkg_name = $req->pkgName;
            $package->reg_discount = $req->reg_discount;
            $package->distribution_id = $dist_id;
            $package->user_id = $userID;
            $package->save();
            session()->put('success', 'Package is successfully added.');
        } else {
            session()->put('error', 'This package is already added to the system!');
        }

        return redirect('/dists/admin/packages');
    }

    public function edit_package(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $distID = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $distID = session()->get('admin')['distribution_id'];
        }
        $type = $req->pkg_type;
        $size = $req->pkg_size . $req->units;
        $pkgName = $req->pkg_name;
        $discount = $req->reg_discount;

        Package::where([
            ['id', $id],
            ['user_id', $userID]
        ])->update([
            'pkg_type' => $type,
            'size' => $size,
            'pkg_name' => $pkgName,
            'reg_discount' => $discount
        ]);

        Product::where([
            ['user_id', $userID],
            ['distribution_id', $distID]
        ])->update([
            "pkg_name" => $pkgName
        ]);

        session()->put('update', 'Package is successfully updated.');
        return redirect('/dists/admin/packages');
    }

    public function delete_package($id)
    {
        $package = Package::find($id);
        $userID = $package->user_id;
        $distID = $package->distribution_id;

        Product::where([
            ['user_id', $userID],
            ["distribution_id", $distID],
            ['pkg_name', $package->pkg_name]
        ])->delete();

        Package::destroy($id);
        session()->put('delete', 'Package is successfully deleted.');
        return redirect('/dists/admin/packages');
    }

    public function getPkgDetails(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $pkgData = Package::where([
            'user_id' => $userID,
            'distribution_id' => $dist_id,
            'pkg_name' => $req->pkgName,
            'size' => $req->pkgSize,
        ])->first();
        if ($pkgData != null) return response($pkgData);
        else return response(-1);
    }
}