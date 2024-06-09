<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    

    public function receive()
    {
        return $this->hasMany(Receive::class, 'account_id');
    }
    public function payment()
    {
        return $this->hasMany(Payment::class, 'account_id');
    }
    public function expense()
    {
        return $this->hasMany(Expense::class, 'account_id');
    }
}
