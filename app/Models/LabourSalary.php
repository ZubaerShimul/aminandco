<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabourSalary extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function account()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
    
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
