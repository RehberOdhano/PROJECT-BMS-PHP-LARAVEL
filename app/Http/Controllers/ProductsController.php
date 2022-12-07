<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Package;
use App\Models\Category;
use App\Models\Flavor;
use App\Models\User;

Session();

class ProductsController extends Controller
{
    public function index()
    {
        if (session()->has('user')) {
            $id = session()->get('user')['id'];
            $dist_id = session()->get('user')['distribution_id'];
            $status = User::where('id', '=', $id)
                ->select('status')
                ->first();
        }
        if (session()->has('admin')) {
            $id = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
            $status = User::where('id', '=', $id)
                ->select('status')
                ->first();
        }

        if (strcmp($status->status, 'BLOCKED') == 0) {
            if (session()->has('admin')) {
                session()->forget('admin');
            }
            if (session()->has('user')) {
                session()->forget('user');
            }
            return redirect('/');
        } else {
            $products = Product::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $categories = Category::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $flavors = Flavor::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $packages = Package::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $pkgTypesArr = [];
            $pkgSizesArr = [];
            foreach ($packages as $pkg) {
                array_push($pkgTypesArr, $pkg->pkg_type);
                array_push($pkgSizesArr, $pkg->size);
            }
            // removing the duplicates
            $pkgTypesArr = array_unique($pkgTypesArr);
            $pkgSizesArr = array_unique($pkgSizesArr);
            return view('dist-admin-pages.products', [
                'products' => $products,
                'categories' => $categories,
                'flavors' => $flavors,
                'packages' => $packages,
                'pkgSizesArr' => $pkgSizesArr,
                'pkgTypesArr' => $pkgTypesArr,
                "packages" => $packages
            ]);
        }
    }

    public function add_product(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $productData = Product::where('distribution_id', '=', $dist_id)
            ->where('user_id', $userID)
            ->where('product_code', '=', $req->product_code)
            ->first();

        // checks whether product already exists or not... if exists, 
        // then error message will be displayed otherwise the product details
        // will be added accordingly...
        if ($productData == null) {
            $product = new Product();
            $product->distribution_id = $dist_id;
            $product->user_id = $userID;
            $pkg = json_decode($req->pkgName);
            $product->pkg_id = $pkg->pkg_id;
            $product->pkg_name = $pkg->pkg_name;
            $product->product_code = strval($req->product_code);
            $product->category = $req->category;
            $product->flavor = $req->flavor;
            $product->product_name = $req->product_name;
            $product->unit_price = $req->unit_price;
            $product->advance_income_tax = $req->advance_income_tax;
            $product->save();
            session()->put('success', 'Product is successfully added!');
        } else {
            session()->put(
                'warning',
                'Product with same details is already added!'
            );
        }
        return redirect('/dists/admin/products');
    }

    public function edit_product(Request $req, $id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
        } else {
            $userID = session()->get('admin')['id'];
        }
        $pkg = json_decode($req->pkgName);
        $code = $req->product_code;
        $productName = $req->product_name;
        $flavor = $req->flavor;
        $category = $req->category;
        $name = $pkg->pkg_name;
        $price = $req->unit_price;
        $tax = $req->advance_income_tax;
        Product::where([['id', $id], ['user_id', $userID], ["pkg_id", $pkg->pkg_id]])->update([
            'product_code' => $code,
            'product_name' => $productName,
            'flavor' => $flavor,
            'category' => $category,
            'pkg_name' => $name,
            'unit_price' => $price,
            'advance_income_tax' => $tax,
        ]);
        session()->put('update', 'Product is successfully updated!');
        return redirect('/dists/admin/products');
    }

    public function delete_product($id)
    {
        Product::destroy($id);
        session()->put('delete', 'Product is successfully deleted!');
        return redirect('/dists/admin/products');
    }
}