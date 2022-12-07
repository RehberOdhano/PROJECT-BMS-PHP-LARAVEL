<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'distribution_id',
        'pkg_type',
        'size',
        'pkg_name',
        'reg_discount'
    ];
}
