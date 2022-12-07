<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

Session();
class StockController extends Controller
{
    // display all the stocks - stocks page
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
            $stocks = Stock::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $products = Product::where('distribution_id', '=', $dist_id)
                ->where('user_id', $id)
                ->get();

            $totalQuantity = 0;
            $totalAmount = 0;
            $quantityArr = [];
            $totalAmountArr = [];
            $delivery_dates = [];
            $invoice_nums = [];
            $ids = [];
            if ($stocks->isNotEmpty()) {
                for ($i = 0; $i < count($stocks); $i++) {
                    array_push($ids, $stocks[$i]->id);
                    array_push($delivery_dates, $stocks[$i]->delivery_date);
                    array_push($invoice_nums, $stocks[$i]->invoice_number);
                    $totalQuantity = array_sum($stocks[$i]->quantity);
                    $totalAmount = array_sum($stocks[$i]->total_amount);
                    array_push($quantityArr, $totalQuantity);
                    array_push($totalAmountArr, $totalAmount);
                }
                return view('dist-admin-pages.stock', [
                    'products' => $products,
                    'totalQuantity' => $quantityArr,
                    'totalAmount' => $totalAmountArr,
                    'dates' => $delivery_dates,
                    'invoice_nums' => $invoice_nums,
                    'ids' => $ids,
                ]);
            } else {
                return view('dist-admin-pages.stock', [
                    'ids' => $ids,
                    'products' => $products,
                ]);
            }
        }
    }

    // displays the add-stock page
    public function add_stock_page()
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $products = Product::where('distribution_id', '=', $dist_id)
            ->where('user_id', $userID)
            ->get();

        return view('dist-admin-pages.add-stock', ['products' => $products]);
    }

    // adds stock
    public function add_stock(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $data = Stock::where([
            ['user_id', '=', $userID],
            ['distribution_id', '=', $dist_id],
            ['invoice_number', '=', $req->invoiceNumber],
        ])->get();

        $pkgData = Package::where('distribution_id', '=', $dist_id)
            ->where('user_id', '=', $userID)
            ->get();

        $pkgNamesArr = [];
        foreach ($pkgData as $pkg) {
            if (in_array(strtoupper($pkg->size), $req->sizes)) {
                array_push($pkgNamesArr, $pkg->package_name);
            }
        }

        // if the stock with the invoice number = $req->invoiceNumber doesn't
        // already exists then we'll simply add it to the database...
        if (!$data->isNotEmpty()) {
            $stock_data = Stock::create([
                'user_id' => $userID,
                'distribution_id' => $dist_id,
                'delivery_date' => $req->date,
                'invoice_number' => $req->invoiceNumber,
                'product_code' => $req->productCodes,
                'product_name' => $req->names,
                'pkg_size' => $req->sizes,
                'pkg_type' => $req->types,
                'unit_price' => $req->unit_prices,
                'total_amount' => $req->amounts,
                'quantity' => $req->quantities,
                'reg_discount' => $req->discounts,
                'adv_income_tax' => $req->taxes,
            ]);
            session()->put('success', 'Stock is successfully added.');
            return response()->json([
                'status' => 'success',
                'data' => $stock_data,
            ]);
        }
        // if the stock with the invoice number = $req->invoiceNumber
        // already exists, then we'll add it to the database accordingly...
        else {
            $productCodes = array_merge(
                $data['0']->product_code,
                $req->productCodes
            );
            $productNames = array_merge($data['0']->product_name, $req->names);
            $pkgSizes = array_merge($data['0']->pkg_size, $req->sizes);
            $pkgTypes = array_merge($data['0']->pkg_type, $req->types);
            $unitPrices = array_merge(
                $data['0']->unit_price,
                $req->unit_prices
            );
            $regDiscounts = array_merge(
                $data['0']->reg_discount,
                $req->discounts
            );
            $advIncomeTaxes = array_merge(
                $data['0']->adv_income_tax,
                $req->taxes
            );
            $quantities = array_merge($data['0']->quantity, $req->quantities);
            $totalAmounts = array_merge(
                $data['0']->total_amount,
                $req->amounts
            );
            Stock::where('distribution_id', $dist_id)
                ->where('user_id', $userID)
                ->where('invoice_number', $req->invoiceNumber)
                ->update([
                    'product_code' => $productCodes,
                    'product_name' => $productNames,
                    'pkg_size' => $pkgSizes,
                    'pkg_type' => $pkgTypes,
                    'unit_price' => $unitPrices,
                    'reg_discount' => $regDiscounts,
                    'adv_income_tax' => $advIncomeTaxes,
                    'quantity' => $quantities,
                    'total_amount' => $totalAmounts,
                ]);
            session()->put('success', 'Stock is successfully added.');
            return response()->json([
                'status' => 'success',
            ]);
        }
    }

    public function edit_stock(Request $req, $id, $code)
    {
        return $req->all();
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        if ($req->product_code) {

            $stock_data = Stock::where('distribution_id', '=', $dist_id)
                ->where('user_id', $userID)
                ->first();

            $delivery_date = $req->date;
            $invoice_number = $req->invoice_num;
            $product_code = $req->product_code;
            $quantity = $req->quantity;
            $product_name = $stock_data->product_name;
            $pkg_name = $stock_data->pkg_name;
            $pkg_size = $stock_data->pkg_size;
            $unit_price = $stock_data->unit_price;
            $reg_discount = $req->reg_discount;
            $adv_income_tax = $req->adv_income_tax;
            $cost = $quantity * $unit_price;
            $cost = $cost - ($cost * $reg_discount + $cost * $adv_income_tax);
            $total_amount = $cost;
            Stock::where([[['id', $id], ['user_id', $userID]]])->update([
                'delivery_date' => $delivery_date,
                'invoice_number' => $invoice_number,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'pkg_name' => $pkg_name,
                'pkg_size' => $pkg_size,
                'unit_price' => $unit_price,
                'reg_discount' => $reg_discount,
                'adv_income_tax' => $adv_income_tax,
                'quantity' => $quantity,
                'total_amount' => $total_amount,
            ]);
        } else {
            $data = Stock::where('id', '=', $id)->get();
            $date = $req->date == '' ? $data['0']->delivery_date : $req->date;
            $invoice_num =
                $req->invoice_num == ''
                ? $data['0']->invoice_number
                : $req->invoice_number;
            $quantity =
                $req->quantity == '' ? $data['0']->quantity : $req->quantity;
            $total_amount = 10;
            DB::update(
                'UPDATE stocks SET delivery_date = ?, invoice_number = ?,
            quantity = ?, total_amount = ? WHERE id = ?, admin_id = ?',
                [$date, $invoice_num, $quantity, $total_amount, $id, $userID]
            );
        }
        session()->put('update', 'Stock is successfully updated.');
        return redirect('/dists/admin/stock');
    }

    // deletes the stock...
    public function delete_stock($id)
    {
        Stock::destroy($id);
        session()->put('delete', 'Stock is successfully deleted.');
        return redirect('/dists/admin/stocks');
    }

    // displays the entire details of an stock with invoice number $invoiceNumber
    public function viewStockDetails($id)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $invoiceData = Stock::where([
            ['user_id', '=', $userID],
            ['distribution_id', '=', $dist_id],
            ['id', '=', $id],
        ])->get();

        $grandTotal = array_sum($invoiceData['0']->total_amount);
        $productCodes = $invoiceData['0']->product_code;
        $productNames = $invoiceData['0']->product_name;
        $pkgTypes = $invoiceData['0']->pkg_type;
        $pkgSizes = $invoiceData['0']->pkg_size;
        $unitPrices = $invoiceData['0']->unit_price;
        $regDiscounts = $invoiceData['0']->reg_discount;
        $advIncomeTaxes = $invoiceData['0']->adv_income_tax;
        $totalAmounts = $invoiceData['0']->total_amount;
        $Quantities = $invoiceData['0']->quantity;

        return view('dist-admin-pages.stock-details', [
            'stocks' => $invoiceData,
            'productCodes' => $productCodes,
            'total' => $grandTotal,
            'productNames' => $productNames,
            'pkgTypes' => $pkgTypes,
            'pkgSizes' => $pkgSizes,
            'unitPrices' => $unitPrices,
            'advIncomeTaxes' => $advIncomeTaxes,
            'regDiscounts' => $regDiscounts,
            'totalAmounts' => $totalAmounts,
            'Quantities' => $Quantities,
        ]);
    }

    // generate the pdf of stock details...
    public function printStockDetails($num)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }
        $invoiceData = Stock::where([
            ['user_id', '=', $userID],
            ['distribution_id', '=', $dist_id],
            ['invoice_number', '=', $num],
        ])->get();
        $grandTotal = 0;
        for ($i = 0; $i < count($invoiceData['0']->total_amount); $i++) {
            if ($invoiceData['0']->quantity[$i] != 0) {
                $grandTotal += $invoiceData['0']->total_amount[$i];
            }
        }
        // this is the data that we'll send to our pdf view...
        $data = [
            'date' => $invoiceData['0']->delivery_date,
            'invoice_num' => $invoiceData['0']->invoice_number,
            'productCodes' => $invoiceData['0']->product_code,
            'productNames' => $invoiceData['0']->product_name,
            'pkgNames' => $invoiceData['0']->pkg_name,
            'pkgSizes' => $invoiceData['0']->pkg_size,
            'unitPrices' => $invoiceData['0']->unit_price,
            'regDiscounts' => $invoiceData['0']->reg_discount,
            'advIncomeTaxes' => $invoiceData['0']->adv_income_tax,
            'quantities' => $invoiceData['0']->quantity,
            'totalAmounts' => $invoiceData['0']->total_amount,
            'grandTotal' => $grandTotal,
        ];
        view()->share('invoice', $data);
        $pdf = FacadePdf::loadView(
            'dist-admin-pages.generate-invoice-pdf',
            $data
        );
        return $pdf->download('invoice.pdf');
    }
}