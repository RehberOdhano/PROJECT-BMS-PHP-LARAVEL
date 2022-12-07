<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_code',
        'product_name',
        'package_size',
        'pkg_type',
        'quantity',
        'original_price',
        'new_price',
        'amount'
    ];

    protected $casts = [
        'product_code' => 'array',
        'product_name' => 'array',
        'package_size' => 'array',
        'pkg_type' => 'array',
        'quantity' => 'array',
        'original_price' => 'array',
        'new_price' => 'array',
        'amount' => 'array'
    ];
}