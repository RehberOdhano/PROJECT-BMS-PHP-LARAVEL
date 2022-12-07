<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'number_plate',
        'make',
        'model',
        'fuel_type',
        'mileage',
        'engine_num',
    ];
}
