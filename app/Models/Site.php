<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function receive()
    {
        return $this->hasMany(Receive::class);
    }
    
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
