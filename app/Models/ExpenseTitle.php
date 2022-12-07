<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseTitle extends Model
{
    use HasFactory;

    public function getTitleSpecificExpenses()
    {
        return $this->hasMany('App\Models\Expense');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($exp) {
            $exp->getTitleSpecificExpenses()->delete();
        });
    }
}