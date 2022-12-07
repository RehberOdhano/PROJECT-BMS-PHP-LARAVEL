<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\Package;
use App\Models\Category;
use App\Models\Stock;
use App\Models\User;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Distribution;

Session();
class DashboardController extends Controller
{
    public function Dashboard()
    {
        if (!session()->has('admin') && !session()->has('user')) {
            return redirect('/');
        } else {
            if (session()->has('admin')) {
                $user = session()->get('admin');
                $status = User::where('id', '=', $user->id)->select('status')->first();
            }
            if (session()->has('user')) {
                $user = session()->get('user');
                $status = User::where('id', '=', $user->id)->select('status')->first();
            }
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
            if (session()->has('admin')) {
                $dist_id = session()->get('admin')['distribution_id'];
                $id = session()->get('admin')['id'];
            } else if (session()->has('user')) {
                $dist_id = session()->get('user')['distribution_id'];
                $id = session()->get('user')['id'];
            }
            $total_sales = Sale::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->count();

            $num_of_employees = Employee::where(
                'distribution_id',
                '=',
                $dist_id
            )
                ->where('user_id', $id)
                ->count();

            $num_of_outlets = Outlet::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->count();

            $packages = collect(
                Package::where('distribution_id', '=', $dist_id)
                    ->where('user_id', $id)
                    ->get()
            );

            $num_of_packages = $packages->count();
            $outlets = Outlet::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $categories = Category::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $stocks = Stock::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $dates = [];
            $invoice_nums = [];
            $productNames = [];
            $productCodes = [];
            $pkgTypes = [];
            $pkgSizes = [];
            $unitPrices = [];
            $regDiscounts = [];
            $taxes = [];
            $quantities = [];
            $totalAmounts = [];
            $ids = [];
            $obj = [];
            for ($i = 0; $i < count($stocks); $i++) {
                array_push($ids, $stocks[$i]->id);
                array_push($dates, $stocks[$i]->delivery_date);
                array_push($invoice_nums, $stocks[$i]->invoice_number);
                for ($j = 0; $j < count($stocks[$i]->product_code); $j++) {
                    array_push($productCodes, $stocks[$i]->product_code[$j]);
                    array_push($productNames, $stocks[$i]->product_name[$j]);
                    array_push($pkgTypes, $stocks[$i]->pkg_type[$j]);
                    array_push($pkgSizes, $stocks[$i]->pkg_size[$j]);
                    array_push($unitPrices, $stocks[$i]->unit_price[$j]);
                    array_push($regDiscounts, $stocks[$i]->reg_discount[$j]);
                    array_push($taxes, $stocks[$i]->adv_income_tax[$j]);
                    array_push($quantities, $stocks[$i]->quantity[$j]);
                    array_push($totalAmounts, $stocks[$i]->total_amount[$j]);
                }
                $obj[$stocks[$i]->id] = [
                    $stocks[$i]->delivery_date,
                    $stocks[$i]->invoice_number,
                    $stocks[$i]->product_code,
                    $stocks[$i]->product_name,
                    $stocks[$i]->pkg_size,
                    $stocks[$i]->pkg_type,
                    $stocks[$i]->unit_price,
                    $stocks[$i]->reg_discount,
                    $stocks[$i]->adv_income_tax,
                    $stocks[$i]->quantity,
                    $stocks[$i]->total_amount,
                ];
            }

            $page = "";
            if ($user) {
                $page = "dist-admin-pages.user-dashboard";
            } else {
                $page = "dist-admin-pages.dashboard-ecommerce";
            }

            return view($page, [
                'total_sales' => $total_sales,
                'num_of_employees' => $num_of_employees,
                'num_of_outlets' => $num_of_outlets,
                'num_of_packages' => $num_of_packages,
                'outlets' => $outlets,
                'categories' => $categories,
                'ids' => $ids,
                'obj' => $obj,
            ]);
        }
    }

    public function SuperAdminDashboard(Request $req)
    {
        if ($req->session()->has('superadmin')) {
            $totalAdmins = User::where('role', 2)->count();
            $totalUsers = User::where('role', 3)->count();
            $total_payments = Payment::count();
            $total_distributors = Distribution::count();
            $admins = User::where('role', '=', 2)->get();
            $distributions = Distribution::where('id', '>=', 1)->get();

            return view('super-admin.dashboard-ecommerce', [
                'totalAdmins' => $totalAdmins,
                'totalUsers' => $totalUsers,
                'total_payments' => $total_payments,
                'total_distributions' => $total_distributors,
                'admins' => $admins,
                'distributions' => $distributions,
            ]);
        } else {
            return redirect('/');
        }
    }

    public function dashboardAnalytics()
    {
        return view('dist-admin-pages.dashboard-analytics');
    }
}