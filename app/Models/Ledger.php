<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'date',
        'description',
        'payment_type',
        'out',
        'in'
    ];
}
