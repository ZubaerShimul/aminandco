<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function receive()
    {
        return $this->hasMany(Receive::class);
    }
    
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function expense()
    {
        return $this->hasMany(Expense::class);
    }
}
