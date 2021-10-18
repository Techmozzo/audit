<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assertion extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_test_id','company_id','completeness','existence','accuracy','valuation','obligation_right','disclosure_presentation'
    ];
}
