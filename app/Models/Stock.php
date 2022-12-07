<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'delivery_date',
        'invoice_number',
        'product_code',
        'product_name',
        'pkg_size',
        'pkg_type',
        'unit_price',
        'reg_discount',
        'adv_income_tax',
        'quantity',
        'total_amount'
    ];

    protected $casts = [
        'product_code' => 'array',
        'product_name' => 'array',
        'pkg_size' => 'array',
        'pkg_type' => 'array',
        'unit_price' => 'array',
        'reg_discount' => 'array',
        'adv_income_tax' => 'array',
        'quantity' => 'array',
        'total_amount' => 'array'
    ];
}
