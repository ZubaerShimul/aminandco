<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseIncome extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
