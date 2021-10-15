<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialityBenchmark extends Model
{
    use HasFactory;

    protected $guard = [];
    protected $fillable = ['planning_id', 'company_id', 'amount', 'reason'];
}
