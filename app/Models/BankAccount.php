<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
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
