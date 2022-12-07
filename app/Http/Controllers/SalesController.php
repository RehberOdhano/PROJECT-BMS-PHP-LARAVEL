<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Outlet;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Package;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LedgerController;

Session();

class SalesController extends Controller
{
    public function index()
    {
        // checks wether user or admin is logged in the system
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

        // checks whether the authenticated user's/admin's account is blocked
        // or active...
        if (strcmp($status->status, 'BLOCKED') == 0) {
            if (session()->has('admin')) {
                session()->forget('admin');
            }
            if (session()->has('user')) {
                session()->forget('user');
            }
            return redirect('/');
        } else {
            // grand total of an specific sale...
            $totalSale = Sale::where('distribution_id', '=', $dist_id)
                ->where('user_id', '=', $id)
                ->select('total_amount')
                ->first();

            // set the totalSale to null if there is no sale details in the database
            // other set the totalSale to total amount...
            // $totalSale != null ? $totalSale->total_amount : 0;

            // get all sales
            $sales = Sale::where('distribution_id', '=', $dist_id)
                ->where('user_id', '=', $id)
                ->get();

            return view('dist-admin-pages.sales', [
                'sales' => $sales,
                'totalSale' =>  $totalSale != null ? $totalSale->total_amount : 0,
            ]);
        }
    }

    // add sales page
    public function addSalePage()
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        $sales = Sale::where('distribution_id', '=', $dist_id)
            ->where('user_id', $userID)
            ->get();

        $outlets = Outlet::where('distribution_id', '=', $dist_id)
            ->where('user_id', $userID)
            ->get();

        $drivers = Employee::where([
            ['user_id', '=', $userID],
            ['distribution_id', '=', $dist_id],
            ['designation', '=', 'driver'],
        ])->get();

        $salesman = Employee::where([
            ['user_id', '=', $userID],
            ['distribution_id', '=', $dist_id],
            ['designation', '=', 'salesman'],
        ])->get();

        $products = Stock::where('distribution_id', '=', $dist_id)
            ->where('user_id', $userID)
            ->get();

        $vehicles = Vehicle::where('distribution_id', '=', $dist_id)
            ->where('user_id', $userID)
            ->get();

        return view('dist-admin-pages.add-sale', [
            'sales' => $sales,
            'outlets' => $outlets,
            'salesmans' => $salesman,
            'drivers' => $drivers,
            'products' => $products,
            'vehicles' => $vehicles,
        ]);
    }

    // this function is used to add sale... first we check whether the item is
    // available in the stock or not... if available then we'll add the sale in the
    // sales table and also update the stocks table accordingly...
    public function add_sale(Request $req)
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $dist_id = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $dist_id = session()->get('admin')['distribution_id'];
        }

        // $stockData = Stock::where('distribution_id', $dist_id)
        //     ->where('user_id', $userID)
        //     ->get();

        $productCodes = array();
        $invoiceNums = array();

        foreach ($req->productCodes as $productCode) {
            $temp = explode("-", $productCode);
            array_push($productCodes, $temp[0]);
            array_push($invoiceNums, $temp[1]);
        }

        // creating a hashmap
        $hashMap = array();
        $i = 0;
        foreach ($invoiceNums as $invoiceNum) {
            if (!array_key_exists($invoiceNum, $hashMap)) {
                $hashMap[$invoiceNum] = [$productCodes[$i]];
            } else {
                array_push($hashMap[$invoiceNum], $productCodes[$i]);
            }
            $i++;
        }

        // form data...
        $productNames = $req->names;
        $pkgSizes = $req->sizes;
        $pkgTypes = $req->types;
        $orgPrices = $req->org_prices;
        $newPrices = $req->new_prices;
        $totalAmounts = $req->amounts;
        $productQuantities = $req->quantities;

        // here we'll check whether the products in the product's list are available
        // in the stock or not... if not, then the system will display an error message
        // otherwise, the sale will be added to the database and the quantity/stock of the
        // products will be subtracted accordingly in the stocks table...
        $inStock = true;
        $index = 0;
        $indices = [];
        $productInvoiceNums = [];
        $map = [];

        foreach ($hashMap as $invoiceNum => $code) {
            $stockData = Stock::where('distribution_id', $dist_id)
                ->where('user_id', $userID)
                ->where('invoice_number', $invoiceNum)
                ->select(array('invoice_number', 'product_code', 'quantity', 'total_amount'))
                ->get();

            $quantities = $stockData[0]->quantity;
            $pCodes = $stockData[0]->product_code;

            $length = count($code);
            for ($i = 0; $i < $length;) {
                $index = array_search($code[$i], $pCodes);
                if ($index !== 0 || $index !== false) {
                    if (!($quantities[$index] > 0 && $productQuantities[$i] <= $quantities[$index])) {
                        $inStock = false;
                        break;
                    } else {
                        array_push($indices, $index);
                        array_push($productInvoiceNums, $stockData[0]->invoice_number);
                        $i++;
                    }
                } else $i++;
            }

            $map[$invoiceNum] = $indices;
            $indices = [];

            if (!$inStock) break;
        }

        // if the product isn't in stock, then a message will be displayed otherwise
        // the sale will be added in the database and the quantity/stock of that
        // particular product will be deducted accordingly...
        if (!$inStock) {
            session()->put('not in stock', 'Item is not available in stock!');
            return json_encode(['status' => 'not in stock']);
        } else {
            $sale = new Sale();
            $sale->user_id = $userID;
            $sale->distribution_id = $dist_id;
            $sale->outlet = $req->outlet;
            $sale->vehicle_number = $req->vehicle;
            $sale->driver_name = $req->driver;
            $sale->route = $req->route;
            $sale->salesman = $req->salesman;
            $sale->total_amount = $req->totalAmount;
            $sale->amount_received = $req->amountPaid;
            $sale->due_amount = $req->amountDue;
            $sale->save();

            $index = 0;
            foreach ($map as $invoiceNum => $indices) {
                foreach ($indices as $i) {
                    $saleDetail = new SaleDetail();
                    $saleDetail->sale_id = $sale->id;
                    $saleDetail->product_code = $productCodes[$index];
                    $saleDetail->product_name = $productNames[$i];
                    $saleDetail->package_size = $pkgSizes[$i];
                    $saleDetail->pkg_type = $pkgTypes[$i];
                    $saleDetail->quantity = $productQuantities[$index];
                    $saleDetail->original_price = $orgPrices[$i];
                    $saleDetail->new_price = $newPrices[$i] == -1 ? 0 : $newPrices[$i];
                    $saleDetail->amount = $totalAmounts[$i];
                    $saleDetail->save();

                    $specificStock = Stock::where("invoice_number", "=", $invoiceNum)
                        ->first();

                    // deducting the quantity of the product and adjusting the total amount
                    // accordingly
                    $quantities = $specificStock->quantity;
                    // $data["before"] = $quantities;
                    if ($quantities[$i] > $productQuantities[$index]) {
                        $quantities[$i] = strval(
                            $quantities[$i] - $productQuantities[$index]
                        );
                    } else {
                        $quantities[$i] = strval(
                            $productQuantities[$index] - $quantities[$i]
                        );
                    }
                    // $data["after"] = $quantities;
                    // $data["productQuantities"] = $productQuantities;
                    // return $data;
                    $index++;

                    $stockAmounts = $specificStock->total_amount;
                    $totalCost = $quantities[$i] * $specificStock->unit_price[$i];
                    $totalCost += ($specificStock->adv_income_tax[$i] / 100) * $totalCost;
                    $totalCost -= ($specificStock->reg_discount[$i] / 100) * $totalCost;
                    $stockAmounts[$i] = strval($totalCost);

                    // updating the stock data...
                    Stock::where([
                        'user_id' => $userID,
                        'distribution_id' => $dist_id,
                        'invoice_number' => $specificStock->invoice_number,
                    ])->update([
                        'quantity' => $quantities,
                        'total_amount' => $stockAmounts,
                    ]);
                }
            }

            $data["sale_id"] = $sale->id;
            $data["outlet"] = $req->outlet;
            $data["salesman"] = $req->salesman;
            $data["total_amount"] = $req->totalAmount;
            $data["amount_paid"] = $req->amountPaid;
            $data["amount_due"] = $req->amountDue;

            // adding the necessary/required information, related to the sales,
            // in ledgers' table...
            (new LedgerController)->addLedger($data);

            session()->put(
                'success',
                'Sale is successfully added & ledger is successfully maintained!'
            );
            return json_encode(['status' => true]);
        }
    }

    // while choosing a product on add-sales page, an ajax request will be sent
    // and the function will be executed and all the information related to that
    // specific product will be returned to the add-sales page and displayed accordingly...
    public function searchProduct()
    {
        if (session()->has('user')) {
            $userID = session()->get('user')['admin_id'];
            $distID = session()->get('user')['distribution_id'];
        } else {
            $userID = session()->get('admin')['id'];
            $distID = session()->get('admin')['distribution_id'];
        }

        $searchTerm = request('product-code');

        if (strlen($searchTerm) > 0) {
            $dataObj = [];

            // gets the data from the database based on the selected product code...
            $productData = DB::select(
                DB::raw(
                    "SELECT * FROM products WHERE product_code LIKE '$searchTerm%'"
                )
            );

            // based on the found product, gets the package data from the database...
            $pkgData = Package::where('distribution_id', $distID)
                ->where('user_id', $userID)
                ->where('id', $productData['0']->pkg_id)
                ->get();

            $dataObj['product'] = $productData;
            $dataObj['pkg'] = $pkgData;

            // sends the entire gathered data
            return response($dataObj);
        }
    }

    // sales details page...
    public function getSpecificStockDetails($id)
    {
        $saleData = SaleDetail::where('sale_id', '=', $id)->get();
        return view('dist-admin-pages.sales-details', ["sales" => $saleData]);
    }

    // deletes the sales details as well as the related ledger data...
    public function delete_sale($id)
    {
        $sale = Sale::find($id);
        $sale->getSaleSpecificDetails()->delete();
        $sale->getSaleSpecificLedger()->delete();
        $sale->delete();
        session()->put('delete', 'Sale is successfully deleted!');
        return redirect('/dists/admin/sales');
    }
}