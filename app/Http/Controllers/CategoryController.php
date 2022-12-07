<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Distribution;
use App\Models\User;
use App\Models\Product;

Session();

class CategoryController extends Controller
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
            $data = session()->get('admin');
            $status = Distribution::where('admin', $data->email)
                ->select('status')
                ->first();
        }

        if ($status == "BLOCKED") {
            if (session()->has('user')) {
                session()->forget('user');
            } else {
                session()->forget('admin');
            }
            return redirect('/');
        } else {
            $data = Category::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)->get();
            return view('dist-admin-pages.categories', ["details" => $data]);
        }
    }

    public function add_category(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $category_data = array();
        for ($i = 0; $i < count($req->category_names); $i++) {
            $categoryData = Category::where('user_id', $userID)
                ->where('distribution_id', $dist_id)
                ->where('category_name', $req->category_names[$i])
                ->first();
            if ($categoryData == null) {
                array_push($category_data, ["user_id" => $userID, "distribution_id" => $dist_id, "category_name" => $req->category_names[$i], "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')]);
            }
        }

        if (count($category_data) > 0) {
            Category::insert($category_data);
            session()->put('success', 'Category is successfully added.');
        } else {
            session()->put('error', 'The category is adready added to the system!');
        }

        return redirect('/dists/admin/categories');
    }

    public function edit_category(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $distID = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $distID = session()->get('admin')['distribution_id'];
        }

        Category::where([
            ["id", $id],
            ["user_id", $userID]
        ])->update([
            "category_name" => $req->category_name
        ]);

        Product::where([
            ['user_id', $userID],
            ['distribution_id', $distID]
        ])->update([
            "category" => $req->category_name
        ]);

        session()->put('update', 'Category is successfully updated.');
        return redirect('/dists/admin/categories');
    }

    public function delete_category($id)
    {

        $category = Category::find($id);
        $userID = $category->user_id;
        $distID = $category->distribution_id;

        Product::where([
            ['user_id', $userID],
            ["distribution_id", $distID],
            ['category', $category->category_name]
        ])->delete();

        Category::destroy($id);

        session()->put('delete', 'Category is successfully deleted.');
        return redirect('/dists/admin/categories');
    }
}