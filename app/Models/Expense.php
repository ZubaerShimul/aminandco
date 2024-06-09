<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function account()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getDocumentAttribute($document){
        return asset($document);
    }
}
