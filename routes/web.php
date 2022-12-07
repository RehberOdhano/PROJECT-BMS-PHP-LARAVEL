<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\FlavorController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\DebitCreditController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTitleController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminPanelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
=============================================================================
|                             AUTHENTICATION ROUTES                         |              
=============================================================================
*/

Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);
Route::get('/logout/{id}', [AuthController::class, 'logout']);

/*
=============================================================================
|                             SUPERADMIN ROUTES                             |              
=============================================================================
*/

// SUPERADMIN DASHBOARD/HOME ROUTE
Route::get('/superadmin/dashboard', [
    DashboardController::class,
    'SuperAdminDashboard',
]);

// SUPERADMIN DISTRIBUTIONS ROUTES
Route::prefix('superadmin')->middleware('auth')->group(function () {
    Route::post('dists/add', [
        DistributionController::class,
        'add_distribution',
    ]);
    Route::post('dists/edit/{id}', [DistributionController::class, 'update']);
    Route::post('dists/delete/{id}', [
        DistributionController::class,
        'delete_dist',
    ]);
    Route::post('dists/block/{id}', [
        DistributionController::class,
        'block_dist',
    ]);
    Route::post('dists/unblock/{id}', [
        DistributionController::class,
        'unBlockDist',
    ]);
    Route::post('dists/add/admin/{id}', [
        DistributionController::class,
        'add_dist_admin',
    ]);
    Route::post('dists/change/admin/{id}', [
        DistributionController::class,
        'changeDistAdmin',
    ]);
    Route::get('dists/search', [
        DistributionController::class,
        'search_distribution',
    ]);
});

// SUPERADMIN ADMIN ROUTES
Route::prefix('superadmin')->middleware('auth')->group(function () {
    Route::post('admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/delete/{id}', [AdminController::class, 'delete']);
});

// SUPERADMIN DASHBOARD ROUTES
Route::prefix('superadmin')->middleware('auth')->group(function () {
    Route::get('admins', [AdminController::class, 'listAdmins']);
    Route::post('edit/profile/{id}', [
        SuperAdminPanelController::class,
        'editProfile',
    ]);
    Route::get('distributions', [DistributionController::class, 'index']);
    Route::get('profile', [SuperAdminPanelController::class, 'profile']);
    Route::get('payments', [PaymentController::class, 'index']);
});

// SUPERADMIN PAYEMENT ROUTES
Route::prefix('superadmin')->middleware('auth')->group(function () {
    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payments/add/{id}', [PaymentController::class, 'add_payment']);
    Route::post('payments/edit/{id}', [
        PaymentController::class,
        'edit_payment',
    ]);
    Route::get('payment/search', [PaymentController::class, 'searchPayment']);
});

/*
=============================================================================
|                             ADMIN ROUTES                                  |              
=============================================================================
*/

// ADMIN DASHBOARD/HOME ROUTE
Route::get('/dists/admin/dashboard', [
    DashboardController::class,
    'Dashboard',
])->middleware('auth');

// ADMIN DASHBOARD ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::get('stocks', [StockController::class, 'index']);
    Route::get('sales', [SalesController::class, 'index']);
    Route::get('invoices', [InvoiceController::class, 'index']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('packages', [PackageController::class, 'index']);
    Route::get('flavors', [FlavorController::class, 'index']);
    Route::get('suppliers', [SupplierController::class, 'index']);
    Route::get('outlets', [OutletController::class, 'index']);
    Route::get('debit-credit', [DebitCreditController::class, 'index']);
    Route::get('employees', [EmployeeController::class, 'index']);
    Route::get('users', [UsersController::class, 'index']);
    Route::get('expenses', [ExpenseController::class, 'index']);
    Route::get('expense/titles', [ExpenseTitleController::class, 'index']);
    Route::get('reports', [ReportController::class, 'index']);
    Route::get('products', [ProductsController::class, 'index']);
    Route::get('ledger', [LedgerController::class, 'index']);
    Route::get('vehicle', [VehicleController::class, 'index']);
    Route::get('profile', [AdminController::class, 'profile']);
    Route::post('edit/profile/{id}', [
        AdminController::class,
        'editAdminProfile',
    ]);
});

// ADMIN STOCKS ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::get('add/stock', [StockController::class, 'add_stock_page']);
    Route::post('addStock', [StockController::class, 'add_stock']);
    Route::post('edit/stock/{id}/{code}', [StockController::class, 'edit_stock']);
    Route::post('delete/stock/{id}', [StockController::class, 'delete_stock']);
    Route::get('stock/details/{id}', [
        StockController::class,
        'viewStockDetails',
    ]);
    Route::get('stock/print/details/{num}', [
        StockController::class,
        'printStockDetails',
    ]);
});

// ADMIN SALES ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::get('add/sale', [SalesController::class, 'addSalePage']);
    Route::post('addSale', [SalesController::class, 'add_sale']);
    Route::post('edit/sale/{id}', [SalesController::class, 'edit_sale']);
    Route::post('delete/sale/{id}', [SalesController::class, 'delete_sale']);
    Route::get('sales/details/{id}', [SalesController::class, 'getSpecificStockDetails']);
    Route::get('/search/product', [SalesController::class, 'searchProduct']);
});

// USER DASHBOARD ROUTE
Route::get('/user/dashboard', [
    DashboardController::class,
    'Dashboard',
])->middleware('auth');

// USER ROUTES
Route::prefix('dists/admin/users')->middleware('auth')->group(function () {
    Route::post('add', [UsersController::class, 'addUser']);
    Route::post('edit/{id}', [UsersController::class, 'editUser']);
    Route::post('delete/{id}', [UsersController::class, 'deleteUser']);
});

// ADMIN CATEGORIES ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/category', [CategoryController::class, 'add_category']);
    Route::post('edit/category/{id}', [
        CategoryController::class,
        'edit_category',
    ]);
    Route::post('delete/category/{id}', [
        CategoryController::class,
        'delete_category',
    ]);
});

// ADMIN FLAVORS ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/flavor', [FlavorController::class, 'add_flavor']);
    Route::post('edit/flavor/{id}', [FlavorController::class, 'edit_flavor']);
    Route::post('delete/flavor/{id}', [
        FlavorController::class,
        'delete_flavor',
    ]);
});

// ADMIN PACKAGE ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::get('search/package', [PackageController::class, 'getPkgDetails']);
    Route::post('add/package', [PackageController::class, 'add_package']);
    Route::post('edit/package/{id}', [
        PackageController::class,
        'edit_package',
    ]);
    Route::post('delete/package/{id}', [
        PackageController::class,
        'delete_package',
    ]);
});

// ADMIN PRODUCT ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/product', [ProductsController::class, 'add_product']);
    Route::post('edit/product/{id}', [
        ProductsController::class,
        'edit_product',
    ]);
    Route::post('delete/product/{id}', [
        ProductsController::class,
        'delete_product',
    ]);
});

// ADMIN SUPPLIER ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/supplier', [SupplierController::class, 'add_supplier']);
    Route::post('edit/supplier/{id}', [
        SupplierController::class,
        'edit_supplier',
    ]);
    Route::post('delete/supplier/{id}', [
        SupplierController::class,
        'delete_supplier',
    ]);
});

// ADMIN OUTLETS ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/outlet', [OutletController::class, 'add_outlet']);
    Route::post('edit/outlet/{id}', [OutletController::class, 'edit_outlet']);
    Route::post('delete/outlet/{id}', [
        OutletController::class,
        'delete_outlet',
    ]);
    Route::get('outlet/get-routes', [OutletController::class, 'getOutletRoutes']);
});

// ADMIN EMPLOYEES ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/employee', [EmployeeController::class, 'add_employee']);
    Route::post('edit/employee/{id}', [
        EmployeeController::class,
        'edit_employee',
    ]);
    Route::post('delete/employee/{id}', [
        EmployeeController::class,
        'delete_employee',
    ]);
});

// ADMIN EXPENSES ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('/add/expenses', [ExpenseController::class, 'add_expense']);
    Route::post('edit/expense/{id}', [
        ExpenseController::class,
        'edit_expense',
    ]);
    Route::post('delete/expense/{id}', [
        ExpenseController::class,
        'delete_expense',
    ]);
});

// ADMIN EXPENSES' TITLE ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('/add/expense/title', [ExpenseTitleController::class, 'addExpenseTitle']);
    Route::post('edit/expense/title/{id}', [
        ExpenseTitleController::class,
        'editExpenseTitle',
    ]);
    Route::post('delete/expense/title/{id}', [
        ExpenseTitleController::class,
        'deleteExpenseTitle',
    ]);
});


// ADMIN DEBIT/CREDIT ROUTES
Route::prefix('dists/admin')->middleware('auth')->group(function () {
    Route::post('add/debit-credit', [
        DebitCreditController::class,
        'addDebitDredit',
    ]);
    Route::post('edit/debit-credit/{id}', [
        DebitCreditController::class,
        'editDebitCredit',
    ]);
    Route::post('delete/debit-credit/{id}', [
        DebitCreditController::class,
        'deleteEditCredit',
    ]);
});

// LEDGER ROUTES
Route::prefix('dists/admin/ledger')->middleware('auth')->group(function () {
    Route::post('add', [LedgerController::class, 'addLedger']);
    Route::post('update/{sale_id}', [LedgerController::class, 'updateLedger']);
    Route::post('delete/{id}', [LedgerController::class, 'deleteLedger']);
});

// VEHICLE ROUTES
Route::prefix('dists/admin/vehicles')->middleware('auth')->group(function () {
    Route::post('add', [VehicleController::class, 'addVehicle']);
    Route::post('update/{id}', [VehicleController::class, 'updateVehicle']);
    Route::post('delete/{id}', [VehicleController::class, 'deleteVehicle']);
});