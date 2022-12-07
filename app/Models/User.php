<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'user_id',
        'role',
        'name',
        'email',
        'status',
        'password',
        'bio',
        'phone_number',
        'city',
        'profile',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Distribution');
    }

    public function getAdminSpecificPkgs()
    {
        return $this->hasMany('App\Models\Package');
    }

    public function getAdminSpecificEmp()
    {
        return $this->hasMany('App\Models\Employee');
    }

    public function getAdminSpecificCategories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function getAdminSpecificExpenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public function getAdminSpecificFlavors()
    {
        return $this->hasMany('App\Models\Flavor');
    }

    public function getAdminSpecificProducts()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function getAdminSpecificStocks()
    {
        return $this->hasMany('App\Models\Stock');
    }

    public function getAdminSpecificSuppliers()
    {
        return $this->hasMany('App\Models\Supplier');
    }

    public function getAdminSpecificLedger()
    {
        return $this->hasMany('App\Models\Ledger');
    }

    public function getAdminSpecificOutlet()
    {
        return $this->hasMany('App\Models\Outlet');
    }

    public function getAdminSpecificSale()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function getAdminSpecificVehicle()
    {
        return $this->hasMany('App\Models\Vehicle');
    }

    public function getAdminSpecificDebitCredit()
    {
        return $this->hasMany('App\Models\DebitCredit');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($pkg) {
            $pkg->getAdminSpecificPkgs()->delete();
        });
        static::deleting(function ($employee) {
            $employee->getAdminSpecificEmp()->delete();
        });
        static::deleting(function ($category) {
            $category->getAdminSpecificCategories()->delete();
        });
        static::deleting(function ($expense) {
            $expense->getAdminSpecificExpenses()->delete();
        });
        static::deleting(function ($flavor) {
            $flavor->getAdminSpecificFlavors()->delete();
        });
        static::deleting(function ($product) {
            $product->getAdminSpecificProducts()->delete();
        });
        static::deleting(function ($stock) {
            $stock->getAdminSpecificStocks()->delete();
        });
        static::deleting(function ($supplier) {
            $supplier->getAdminSpecificSuppliers()->delete();
        });
        static::deleting(function ($ledger) {
            $ledger->getAdminSpecificLedger()->delete();
        });
        static::deleting(function ($outlet) {
            $outlet->getAdminSpecificOutlet()->delete();
        });
        static::deleting(function ($sale) {
            $sale->getAdminSpecificSale()->delete();
        });
        static::deleting(function ($vehicle) {
            $vehicle->getAdminSpecificVehicle()->delete();
        });
        static::deleting(function ($debitcredit) {
            $debitcredit->getAdminSpecificDebitCredit()->delete();
        });
    }
}