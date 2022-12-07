<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flavor;
use App\Models\User;
use App\Models\Product;

Session();

class FlavorController extends Controller
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
            $admin = session()->get('admin');
            $status = User::where('id', '=', $admin->id)->select('status')->first();
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
            $data = Flavor::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();
            return view('dist-admin-pages.flavors', ["flavors" => $data]);
        }
    }

    public function add_flavor(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $flavor_data = array();
        for ($i = 0; $i < count(array_unique($req->flavor_names)); $i++) {
            $flavorData = Flavor::where('user_id', $userID)
                ->where('distribution_id', $dist_id)
                ->where('flavor_name', $req->flavor_names[$i])
                ->first();
            if ($flavorData == null) {
                array_push($flavor_data, ["user_id" => $userID, "distribution_id" => $dist_id, "flavor_name" => $req->flavor_names[$i], "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')]);
            }
        }

        if (count($flavor_data) > 0) {
            Flavor::insert($flavor_data);
            session()->put('success', 'Flavor is successfully added.');
        } else {
            session()->put('error', 'The flavor is adready added to the system!');
        }

        return redirect('/dists/admin/flavors');
    }

    public function edit_flavor(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $distID = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $distID = session()->get('admin')['distribution_id'];
        }

        Flavor::where([
            ["id", $id],
            ["user_id", $userID]
        ])->update([
            "flavor_name" => $req->flavor_name
        ]);

        Product::where([
            ['user_id', $userID],
            ['distribution_id', $distID]
        ])->update([
            "flavor" => $req->flavor_name
        ]);

        session()->put('update', 'Flavor is successfully updated.');
        return redirect('/dists/admin/flavors');
    }

    public function delete_flavor($id)
    {
        $flavor = Flavor::find($id);
        $userID = $flavor->user_id;
        $distID = $flavor->distribution_id;

        Product::where([
            ['user_id', $userID],
            ["distribution_id", $distID],
            ['flavor', $flavor->flavor_name]
        ])->delete();

        Flavor::destroy($id);
        session()->put('delete', 'Flavor is successfully deleted.');
        return redirect('/dists/admin/flavors');
    }
}