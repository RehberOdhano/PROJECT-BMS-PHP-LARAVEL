<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'product_code',
        'product_name',
        'category',
        'flavor',
        'pkg_name',
        'unit_price',
        'adv_income_tax',
    ];
}
