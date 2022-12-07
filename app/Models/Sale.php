<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'vehicle_number',
        'driver_name',
        'route',
        'salesman',
        'total_amount',
        'amount_received',
        'amount_paid'
    ];

    public function getSaleSpecificDetails()
    {
        return $this->hasOne('App\Models\SaleDetail');
    }

    public function getSaleSpecificLedger()
    {
        return $this->hasOne('App\Models\Ledger');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($sale) {
            $sale->getSaleSpecificDetails()->delete();
        });
        static::deleting(function ($ledger) {
            $ledger->getSaleSpecificLedger()->delete();
        });
    }
}