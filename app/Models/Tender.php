<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function account()
    {
       return $this->belongsTo(BankAccount::class, 'account_id');
    }
}
