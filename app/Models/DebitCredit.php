<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'date',
        'debit',
        'credit',
        'balance',
    ];
}
