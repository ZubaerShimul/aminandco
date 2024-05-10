<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function account()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
