<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $guard = [];
    protected $fillable = ['company_id', 'engagement_id', 'trial_balance'];

    public function transactionClass(){
        return $this->hasMany(TransactionClass::class);
    }

    public function materialityBenchmark(){
        return $this->hasMany(MaterialityBenchmark::class);
    }
}
