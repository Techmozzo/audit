<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestProcedure extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_test_id', 'company_id', 'description'];
}
