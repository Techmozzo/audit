<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTest extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_class_id', 'company_id', 'name'];

    public function procedure(){
        return $this->hasMany(TestProcedure::class,'transaction_test_id' );
    }

    public function assertion(){
        return $this->hasMany(Assertion::class,'transaction_test_id' );
    }
}
