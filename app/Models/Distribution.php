<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    public function getDistSpecificPkgs()
    {
        return $this->hasMany('App\Models\Package');
    }

    public function getSpecificDistAdmin()
    {
        return $this->hasOne('App\Models\User');
    }

    public function getSpecificDistPayment()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function getSpecificDistEmp()
    {
        return $this->hasMany('App\Models\Employee');
    }

    public function getDistSpecificCategories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function getDistSpecificExpenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function getDistSpecificFlavors()
    {
        return $this->hasMany('App\Models\Flavor');
    }

    public function getDistSpecificProducts()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function getDistSpecificStocks()
    {
        return $this->hasMany('App\Models\Stock');
    }

    public function getDistSpecificSuppliers()
    {
        return $this->hasMany('App\Models\Supplier');
    }

    public function getDistSpecificLedger()
    {
        return $this->hasMany('App\Models\Ledger');
    }

    public function getDistSpecificOutlet()
    {
        return $this->hasMany('App\Models\Outlet');
    }

    public function getDistSpecificSale()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function getDistSpecificVehicle()
    {
        return $this->hasMany('App\Models\Vehicle');
    }

    public function getDistSpecificDebitCredit()
    {
        return $this->hasMany('App\Models\DebitCredit');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($pkg) {
            $pkg->getDistSpecificPkgs()->delete();
        });
        static::deleting(function ($user) {
            $user->getSpecificDistAdmin()->delete();
        });
        static::deleting(function ($payment) {
            $payment->getSpecificDistPayment()->delete();
        });
        static::deleting(function ($employee) {
            $employee->getSpecificDistEmp()->delete();
        });
        static::deleting(function ($category) {
            $category->getDistSpecificCategories()->delete();
        });
        static::deleting(function ($expense) {
            $expense->getDistSpecificExpenses()->delete();
        });
        static::deleting(function ($flavor) {
            $flavor->getDistSpecificFlavors()->delete();
        });
        static::deleting(function ($product) {
            $product->getDistSpecificProducts()->delete();
        });
        static::deleting(function ($stock) {
            $stock->getDistSpecificStocks()->delete();
        });
        static::deleting(function ($supplier) {
            $supplier->getDistSpecificSuppliers()->delete();
        });
        static::deleting(function ($ledger) {
            $ledger->getDistSpecificLedger()->delete();
        });
        static::deleting(function ($outlet) {
            $outlet->getDistSpecificOutlet()->delete();
        });
        static::deleting(function ($sale) {
            $sale->getDistSpecificSale()->delete();
        });
        static::deleting(function ($vehicle) {
            $vehicle->getDistSpecificVehicle()->delete();
        });
        static::deleting(function ($debitcredit) {
            $debitcredit->getDistSpecificDebitCredit()->delete();
        });
    }
}