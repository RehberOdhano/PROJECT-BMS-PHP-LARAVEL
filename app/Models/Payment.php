<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_id',
        'category_name',
        'amount_paid',
        'due_amount',
        'date_amount_paid',
        'status'
    ];
}
